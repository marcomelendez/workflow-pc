<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActividadResource\Pages;
use App\Filament\Resources\ActividadResource\RelationManagers;
use App\Models\Actividad;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActividadResource extends Resource
{
    protected static ?string $model = Actividad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\TextInput::make('nombre')
                        ->label('Nombre')
                        ->required(),
                    Forms\Components\Select::make('tipo')
                        ->label('Tipo')
                        ->options([
                            'tipo1' => 'Tipo 1',
                            'tipo2' => 'Tipo 2',
                            'tipo3' => 'Tipo 3',
                        ])
                        ->required(),
                    Forms\Components\RichEditor::make('descripcion')
                        ->label('Descripción')
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()->color(function ($record) {

                        return $record->estado->color();
                    }),
                \EightyNine\Approvals\Tables\Columns\ApprovalStatusColumn::make("approvalStatus.status"),
            ])
            ->filters([
                //
            ])
            ->actions([
                    ...\EightyNine\Approvals\Tables\Actions\ApprovalActions::make(
                    // define your action here that will appear once approval is completed
                    Tables\Actions\Action::make("Done"),
                    [
                        Tables\Actions\EditAction::make()
                            ->visible(fn (Actividad $record) => !$record->isPending()),
                        Tables\Actions\ViewAction::make()
                    ]
                )
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActividads::route('/'),
            'create' => Pages\CreateActividad::route('/create'),
            'view' => Pages\ViewActividad::route('/{record}'),
            'edit' => Pages\EditActividad::route('/{record}/edit'),
        ];
    }
}
