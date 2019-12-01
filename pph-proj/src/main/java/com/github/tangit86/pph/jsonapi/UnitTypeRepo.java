package com.github.tangit86.pph.jsonapi;

import com.github.tangit86.pph.domain.UnitEnum;
import io.katharsis.queryspec.QuerySpec;
import io.katharsis.repository.ResourceRepositoryBase;
import io.katharsis.resource.list.ResourceList;
import org.springframework.stereotype.Component;

import java.util.HashMap;
import java.util.Map;
import java.util.stream.Collectors;

@Component
public class UnitTypeRepo extends ResourceRepositoryBase<UnitType, Long> {

    private Map<Long, UnitType> unitTypes = new HashMap<>();

    public UnitTypeRepo() {

        super(UnitType.class);

        unitTypes.put(1L, new UnitType(1L, UnitEnum.Celsius.toString()));
        unitTypes.put(2L, new UnitType(2L, UnitEnum.Fahrenheit.toString()));

    }

    @Override
    public ResourceList<UnitType> findAll(QuerySpec querySpec) {
        return querySpec.apply(this.unitTypes.values());
    }

    @Override
    public UnitType findOne(Long id, QuerySpec querySpec) {
        return unitTypes.get(id);
    }

    public UnitType findByName(String name) {
        return unitTypes.values().stream().filter(it -> it.name.equals(name)).collect(Collectors.toList()).get(0);
    }

}
