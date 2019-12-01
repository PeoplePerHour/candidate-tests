package com.github.tangit86.pph.controllers;

import com.github.tangit86.pph.domain.LocationDto;
import com.github.tangit86.pph.domain.ProviderEnum;
import com.github.tangit86.pph.domain.UnitEnum;
import com.github.tangit86.pph.domain.WeatherForecastDto;
import com.github.tangit86.pph.services.WeatherForecastService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class WeatherController {

    @Autowired
    WeatherForecastService weatherForecastService;

    @RequestMapping(value = "/weather", method = RequestMethod.GET)
    public WeatherForecastDto weather(@RequestParam(name = "location") String location,
            @RequestParam(name = "units") UnitEnum unitSystem,
            @RequestParam(name = "provider", required = false) ProviderEnum providerEnum) throws Exception {
        return weatherForecastService.get(new LocationDto(location), unitSystem, providerEnum);
    }

}
