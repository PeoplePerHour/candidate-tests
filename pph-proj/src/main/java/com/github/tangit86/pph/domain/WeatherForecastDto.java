package com.github.tangit86.pph.domain;

public class WeatherForecastDto {
    public LocationDto locationDto;
    public UnitEnum unit;
    public double temperature;
    public String description;

    public WeatherForecastDto(LocationDto locationDto, UnitEnum unit, double temperature, String description) {
        this.locationDto = locationDto;
        this.unit = unit;
        this.temperature = temperature;
        this.description = description;
    }
}
