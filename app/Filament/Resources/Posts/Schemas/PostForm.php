<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([
                TextInput::make('title')
                    ->label('タイトル')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('body')
                    ->label('本文')
                    ->required()
                    ->columnSpan(2)
                    ->extraAttributes([
                        'class' => 'body-rich-editor'
                    ]),
                FileUpload::make('attachment_path')
                    ->label('添付ファイル')
                    ->directory('posts')
                    ->disk('public'),
                    
            ]);
    }
}
