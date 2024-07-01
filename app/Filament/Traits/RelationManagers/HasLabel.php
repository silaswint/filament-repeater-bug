<?php

namespace App\Filament\Traits\RelationManagers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasLabel
{
    public static function transferClassNameToLabel(string $className): string
    {
        return Str::title(Str::snake(class_basename($className), ' '));
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __(Str::plural(self::transferClassNameToLabel(self::getRelationshipName())));
    }

    public static function getModelLabel(): string
    {
        return __(Str::singular(self::transferClassNameToLabel(self::getRelationshipName())));
    }

    public static function getPluralModelLabel(): string
    {
        return __(Str::plural(self::transferClassNameToLabel(self::getRelationshipName())));
    }
}
