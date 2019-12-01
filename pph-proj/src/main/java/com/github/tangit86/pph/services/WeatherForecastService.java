package com.github.tangit86.pph.services;

import com.github.tangit86.pph.domain.LocationDto;
import com.github.tangit86.pph.domain.ProviderEnum;
import com.github.tangit86.pph.domain.UnitEnum;
import com.github.tangit86.pph.domain.WeatherForecastDto;
import com.github.tangit86.pph.providers.ProviderResponseDto;
import com.github.tangit86.pph.providers.WeatherProvider;
import com.github.tangit86.pph.services.exceptions.ProviderNotSupported;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.cache.CacheManager;
import org.springframework.cache.annotation.Cacheable;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Service;

@Service
public class WeatherForecastService {

    Logger logger = LoggerFactory.getLogger(WeatherForecastService.class);

    @Autowired
    CacheManager cacheManager;

    @Autowired
    @Qualifier("openWeatherApi")
    WeatherProvider openWeatherApi;

    @Autowired
    @Qualifier("weatherBitApi")
    WeatherProvider weatherBitApi;

    @Cacheable(value = "forecasts", keyGenerator = "customKeyGenerator")
    public WeatherForecastDto get(LocationDto locationDto, UnitEnum unitEnum, ProviderEnum providerEnum)
            throws Exception {
        logger.info("Fetching from provider...");
        ProviderResponseDto responseDto = getProviderResponse(locationDto, unitEnum, providerEnum);
        return new WeatherForecastDto(locationDto, unitEnum, responseDto.temperature, responseDto.description);
    }

    private ProviderResponseDto getProviderResponse(LocationDto locationDto, UnitEnum unitEnum,
                                                    ProviderEnum providerEnum) throws Exception {
        if (providerEnum == ProviderEnum.OpenWeather || providerEnum == null) {
            return openWeatherApi.get(locationDto, unitEnum);
        } else if (providerEnum == ProviderEnum.WeatherBit) {
            return weatherBitApi.get(locationDto, unitEnum);
        } else {
            throw new ProviderNotSupported();
        }
    }

    @Scheduled(fixedDelayString = "${cache.eviction.delay}")
    protected void cacheEvict() {
        logger.info("Evicting caches...");
        cacheManager.getCache("forecasts").clear();
    }
}
