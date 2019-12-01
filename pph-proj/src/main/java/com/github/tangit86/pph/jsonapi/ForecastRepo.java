package com.github.tangit86.pph.jsonapi;

import com.fasterxml.jackson.databind.JsonMappingException;
import com.github.tangit86.pph.domain.LocationDto;
import com.github.tangit86.pph.domain.ProviderEnum;
import com.github.tangit86.pph.domain.UnitEnum;
import com.github.tangit86.pph.domain.WeatherForecastDto;
import com.github.tangit86.pph.services.WeatherForecastService;

import io.katharsis.queryspec.FilterSpec;
import io.katharsis.queryspec.QuerySpec;
import io.katharsis.repository.ResourceRepositoryBase;
import io.katharsis.resource.list.ResourceList;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

@Component
public class ForecastRepo extends ResourceRepositoryBase<Forecast, String> {

    @Autowired
    WeatherForecastService weatherForecastService;

    @Autowired
    UnitTypeRepo unitTypeRepo;

    @Autowired
    ProviderTypeRepo providerTypeRepo;

    public ForecastRepo() {
        super(Forecast.class);
    }

    @Override
    public ResourceList<Forecast> findAll(QuerySpec querySpec) {
        LocationDto locationDto = null;
        UnitEnum unit = null;
        ProviderEnum provider = ProviderEnum.OpenWeather;

        // hijack katharsis jsonapi filters
        for (int i = 0; i < querySpec.getFilters().size(); i++) {
            FilterSpec filter = querySpec.getFilters().get(i);
            String filterName = filter.getAttributePath().get(0);
            Object filterValue = filter.getValue();

            if (filterName.equals("id")) {
                querySpec.setFilters(new ArrayList<FilterSpec>());
                String[] items = filterValue.toString().replace("[", "").replace("]", "").replace("\"", "")
                        .replace(" ", "").split("_");
                try {
                    locationDto = new LocationDto(items[0]);
                } catch (Exception e) {
                    e.printStackTrace();
                }
                unit = UnitEnum.valueOf(items[1]);
                provider = ProviderEnum.valueOf(items[2]);
            }

            if (filterName.equals("location")) {
                try {
                    locationDto = new LocationDto(filterValue.toString());
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }

            if (filterName.equals("providerType")) {
                provider = ProviderEnum.valueOf(filterValue.toString());
            }

            if (filterName.equals("unitType")) {
                unit = UnitEnum.valueOf(filterValue.toString());
            }
        }

        WeatherForecastDto searchResult = null;

        try {
            searchResult = weatherForecastService.get(locationDto, unit, provider);
        } catch (Exception e) {

            e.printStackTrace();
        }

        return querySpec.apply(new ArrayList<Forecast>(Arrays.asList(map(searchResult, unit, provider))));
    }

    private Forecast map(WeatherForecastDto weatherForecastDto, UnitEnum unit, ProviderEnum provider) {

        ProviderType providerType = providerTypeRepo.findByName(provider.name());
        UnitType unitType = unitTypeRepo.findByName(unit.name());

        return new Forecast(weatherForecastDto.locationDto.toString(), weatherForecastDto.temperature,
                weatherForecastDto.description, unitType, providerType);
    }
}
