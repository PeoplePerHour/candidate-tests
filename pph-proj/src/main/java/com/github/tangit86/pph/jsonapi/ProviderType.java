package com.github.tangit86.pph.jsonapi;

import io.katharsis.resource.annotations.JsonApiId;
import io.katharsis.resource.annotations.JsonApiResource;

@JsonApiResource(type = "provider-type")
public class ProviderType {
    @JsonApiId
    public Long id;

    public String name;

    public ProviderType(Long id, String name) {
        this.id = id;
        this.name = name;
    }
}
