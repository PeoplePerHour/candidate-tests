package com.github.tangit86.pph.jsonapi;

import com.github.tangit86.pph.domain.ProviderEnum;
import io.katharsis.queryspec.QuerySpec;
import io.katharsis.repository.ResourceRepositoryBase;
import io.katharsis.resource.list.ResourceList;
import org.springframework.stereotype.Component;

import java.util.HashMap;
import java.util.Map;
import java.util.stream.Collectors;

@Component
public class ProviderTypeRepo extends ResourceRepositoryBase<ProviderType, Long> {

    private Map<Long, ProviderType> providerTypes = new HashMap<>();

    public ProviderTypeRepo() {

        super(ProviderType.class);

        providerTypes.put(1L, new ProviderType(1L, ProviderEnum.OpenWeather.toString()));
        providerTypes.put(2L, new ProviderType(2L, ProviderEnum.WeatherBit.toString()));

    }

    @Override
    public ResourceList<ProviderType> findAll(QuerySpec querySpec) {
        return querySpec.apply(providerTypes.values());
    }

    @Override
    public ProviderType findOne(Long id, QuerySpec querySpec) {
        return providerTypes.get(id);
    }

    public ProviderType findByName(String name) {
        return providerTypes.values().stream().filter(it -> it.name.equals(name)).collect(Collectors.toList()).get(0);
    }
}
