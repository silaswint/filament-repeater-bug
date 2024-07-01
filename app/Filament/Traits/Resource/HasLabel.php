<?php

namespace App\Filament\Traits\Resource;

use Illuminate\Support\Str;

trait HasLabel
{
    public static function transferClassNameToLabel(string $className): string
    {
        return Str::title(Str::snake(class_basename($className), ' '));
    }

    public static function getNavigationLabel(): string
    {
        return __(Str::plural(self::transferClassNameToLabel(self::getModel())));
    }

    public static function getModelLabel(): string
    {
        return __(Str::singular(self::transferClassNameToLabel(self::getModel())));
    }

    public static function getPluralModelLabel(): string
    {
        return __(Str::plural(self::transferClassNameToLabel(self::getModel())));
    }
}
