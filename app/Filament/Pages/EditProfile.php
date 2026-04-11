<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page
{
    protected string $view = 'filament.pages.edit-profile';

    public static function getNavigationIcon(): \BackedEnum|\Illuminate\Contracts\Support\Htmlable|string|null
    {
        return 'heroicon-o-user-circle';
    }

    public static function getNavigationLabel(): string
    {
        return 'My Profile';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public array $data = [
        'name'                     => '',
        'email'                    => '',
        'phone'                    => '',
        'bio'                      => '',
        'avatar'                   => [],
        'current_password'         => '',
        'new_password'             => '',
        'new_password_confirmation' => '',
    ];

    public function mount(): void
    {
        $user = auth()->user();

        $this->data['name']   = $user->name ?? '';
        $this->data['email']  = $user->email ?? '';
        $this->data['phone']  = $user->phone ?? '';
        $this->data['bio']    = $user->bio ?? '';
        $this->data['avatar'] = [];
    }

    public function getTitle(): string
    {
        return 'My Profile';
    }

    public function form(Schema $schema): Schema
    {
        return $schema->statePath('data')->components([
            Section::make('Profile Picture')
                ->description('Upload a profile photo')
                ->schema([
                    FileUpload::make('avatar')
                        ->label('')
                        ->image()
                        ->imageEditor()
                        ->circleCropper()
                        ->directory('avatars')
                        ->disk('public')
                        ->maxSize(2048)
                        ->columnSpanFull(),
                ]),

            Section::make('Personal Information')
                ->description('Update your name, email and contact details')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(table: 'users', column: 'email', ignorable: auth()->user())
                        ->maxLength(255),

                    TextInput::make('phone')
                        ->tel()
                        ->maxLength(20),

                    Textarea::make('bio')
                        ->label('Bio')
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Change Password')
                ->description('Leave blank if you do not want to change your password')
                ->schema([
                    TextInput::make('current_password')
                        ->label('Current Password')
                        ->password()
                        ->revealable(),

                    TextInput::make('new_password')
                        ->label('New Password')
                        ->password()
                        ->revealable()
                        ->rule(Password::defaults()),

                    TextInput::make('new_password_confirmation')
                        ->label('Confirm New Password')
                        ->password()
                        ->revealable()
                        ->same('new_password'),
                ])->columns(3),
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('save')
                ->icon('heroicon-o-check')
                ->color('primary'),
        ];
    }

    public function deleteAvatar(): void
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
            $user->save();
        }

        $this->data['avatar'] = [];

        Notification::make()
            ->title('Profile photo removed')
            ->success()
            ->send();

        $this->redirect(static::getUrl());
    }

    public function save(): void
    {
        $user = auth()->user();

        $data = $this->form->getState();

        if (filled($data['current_password'] ?? '')) {
            if (! Hash::check($data['current_password'], $user->password)) {
                Notification::make()
                    ->title('Current password is incorrect')
                    ->danger()
                    ->send();
                return;
            }

            if (filled($data['new_password'] ?? '')) {
                $user->password = Hash::make($data['new_password']);
            }
        }

        $user->name  = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->phone = $data['phone'] ?? null;
        $user->bio   = $data['bio'] ?? null;

        $newAvatar = $data['avatar'] ?? [];
        if (is_array($newAvatar)) {
            $newAvatar = array_values(array_filter($newAvatar))[0] ?? null;
        }
        if (filled($newAvatar) && $newAvatar !== $user->avatar) {
            if ($user->avatar && $user->avatar !== $newAvatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $newAvatar;
        }

        $user->save();

        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();

        $this->redirect(filament()->getUrl());
    }
}
