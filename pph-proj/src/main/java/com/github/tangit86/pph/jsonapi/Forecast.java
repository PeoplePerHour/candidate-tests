package com.github.tangit86.pph.jsonapi;

import io.katharsis.resource.annotations.JsonApiId;
import io.katharsis.resource.annotations.JsonApiRelation;
import io.katharsis.resource.annotations.JsonApiResource;

import java.util.UUID;

@JsonApiResource(type = "forecast")
public class Forecast {
    @JsonApiId
    public String id;

    public String location;

    public double temperature;
    public String description;

    @JsonApiRelation
    public UnitType unitType;

    @JsonApiRelation
    public ProviderType providerType;

    public Forecast(String location, double temperature, String description, UnitType unitType,
            ProviderType providerType) {
        this.id = location + "_" + unitType.name + "_" + providerType.name;
        this.location = location;
        this.temperature = temperature;
        this.description = description;
        this.unitType = unitType;
        this.providerType = providerType;
    }
}
