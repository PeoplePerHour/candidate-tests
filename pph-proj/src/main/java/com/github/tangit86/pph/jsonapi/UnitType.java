package com.github.tangit86.pph.jsonapi;

import io.katharsis.resource.annotations.JsonApiId;
import io.katharsis.resource.annotations.JsonApiResource;

@JsonApiResource(type = "unit-type")
public class UnitType {

    @JsonApiId
    public Long typeId;

    public String name;

    public UnitType(Long typeId, String name) {
        this.typeId = typeId;
        this.name = name;
    }
}
