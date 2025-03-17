<?php

namespace App\Enums;

enum Dimension: string
{
    // Length Units
    case MILLIMETER = 'mm';
    case CENTIMETER = 'cm';
    case METER = 'm';
    case KILOMETER = 'km';
    case INCH = 'in';
    case FOOT = 'ft';
    case YARD = 'yd';
    case MILE = 'mi';

    // Mass Units
    case MILLIGRAM = 'mg';
    case GRAM = 'g';
    case KILOGRAM = 'kg';
    case TONNE = 't';
    case OUNCE = 'oz';
    case POUND = 'lb';

    // Volume Units
    case MILLILITER = 'ml';
    case LITER = 'l';
    case CUBIC_CENTIMETER = 'cm3';
    case CUBIC_METER = 'm3';
    case CUBIC_INCH = 'in3';
    case CUBIC_FOOT = 'ft3';
    case GALLON = 'gal';
    case QUART = 'qt';
    case PINT = 'pt';

    // Area Units
    case SQUARE_MILLIMETER = 'mm2';
    case SQUARE_CENTIMETER = 'cm2';
    case SQUARE_METER = 'm2';
    case SQUARE_KILOMETER = 'km2';
    case SQUARE_INCH = 'in2';
    case SQUARE_FOOT = 'ft2';
    case SQUARE_YARD = 'yd2';
    case ACRE = 'ac';
    case HECTARE = 'ha';

    public function type(): string
    {
        return match ($this) {
            // Length
            self::MILLIMETER,
            self::CENTIMETER,
            self::METER,
            self::KILOMETER,
            self::INCH,
            self::FOOT,
            self::YARD,
            self::MILE => 'length',

            // Mass
            self::MILLIGRAM,
            self::GRAM,
            self::KILOGRAM,
            self::TONNE,
            self::OUNCE,
            self::POUND => 'mass',

            // Volume
            self::MILLILITER,
            self::LITER,
            self::CUBIC_CENTIMETER,
            self::CUBIC_METER,
            self::CUBIC_INCH,
            self::CUBIC_FOOT,
            self::GALLON,
            self::QUART,
            self::PINT => 'volume',

            // Area
            self::SQUARE_MILLIMETER,
            self::SQUARE_CENTIMETER,
            self::SQUARE_METER,
            self::SQUARE_KILOMETER,
            self::SQUARE_INCH,
            self::SQUARE_FOOT,
            self::SQUARE_YARD,
            self::ACRE,
            self::HECTARE => 'area',
        };
    }

    public function abbreviation(): string
    {
        return match ($this) {
            // Length
            self::MILLIMETER => 'mm',
            self::CENTIMETER => 'cm',
            self::METER => 'm',
            self::KILOMETER => 'km',
            self::INCH => 'in',
            self::FOOT => 'ft',
            self::YARD => 'yd',
            self::MILE => 'mi',

            // Mass
            self::MILLIGRAM => 'mg',
            self::GRAM => 'g',
            self::KILOGRAM => 'kg',
            self::TONNE => 't',
            self::OUNCE => 'oz',
            self::POUND => 'lb',

            // Volume
            self::MILLILITER => 'ml',
            self::LITER => 'l',
            self::CUBIC_CENTIMETER => 'cm³',
            self::CUBIC_METER => 'm³',
            self::CUBIC_INCH => 'in³',
            self::CUBIC_FOOT => 'ft³',
            self::GALLON => 'gal',
            self::QUART => 'qt',
            self::PINT => 'pt',

            // Area
            self::SQUARE_MILLIMETER => 'mm²',
            self::SQUARE_CENTIMETER => 'cm²',
            self::SQUARE_METER => 'm²',
            self::SQUARE_KILOMETER => 'km²',
            self::SQUARE_INCH => 'in²',
            self::SQUARE_FOOT => 'ft²',
            self::SQUARE_YARD => 'yd²',
            self::ACRE => 'ac',
            self::HECTARE => 'ha',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::MILLIMETER => 'Millimeter - metric unit of length',
            self::CENTIMETER => 'Centimeter - metric unit of length',
            self::METER => 'Meter - metric unit of length',
            self::KILOMETER => 'Kilometer - metric unit of length',
            self::INCH => 'Inch - imperial unit of length',
            self::FOOT => 'Foot - imperial unit of length',
            self::YARD => 'Yard - imperial unit of length',
            self::MILE => 'Mile - imperial unit of length',

            self::MILLIGRAM => 'Milligram - metric unit of mass',
            self::GRAM => 'Gram - metric unit of mass',
            self::KILOGRAM => 'Kilogram - metric unit of mass',
            self::TONNE => 'Tonne - metric unit of mass',
            self::OUNCE => 'Ounce - imperial unit of mass',
            self::POUND => 'Pound - imperial unit of mass',

            self::MILLILITER => 'Milliliter - metric unit of volume',
            self::LITER => 'Liter - metric unit of volume',
            self::CUBIC_CENTIMETER => 'Cubic Centimeter - volume in cm³',
            self::CUBIC_METER => 'Cubic Meter - volume in m³',
            self::CUBIC_INCH => 'Cubic Inch - volume in in³',
            self::CUBIC_FOOT => 'Cubic Foot - volume in ft³',
            self::GALLON => 'Gallon - imperial unit of volume',
            self::QUART => 'Quart - imperial unit of volume',
            self::PINT => 'Pint - imperial unit of volume',

            self::SQUARE_MILLIMETER => 'Square Millimeter - area in mm²',
            self::SQUARE_CENTIMETER => 'Square Centimeter - area in cm²',
            self::SQUARE_METER => 'Square Meter - area in m²',
            self::SQUARE_KILOMETER => 'Square Kilometer - area in km²',
            self::SQUARE_INCH => 'Square Inch - area in in²',
            self::SQUARE_FOOT => 'Square Foot - area in ft²',
            self::SQUARE_YARD => 'Square Yard - area in yd²',
            self::ACRE => 'Acre - imperial unit of land area',
            self::HECTARE => 'Hectare - metric unit of land area',
        };
    }

    public static function all(): array
    {
        return array_map(
            fn ($case) => [
                'value' => $case->value,
                'type' => $case->type(),
                'abbreviation' => $case->abbreviation(),
                'description' => $case->description(),
            ],
            self::cases()
        );
    }
}
