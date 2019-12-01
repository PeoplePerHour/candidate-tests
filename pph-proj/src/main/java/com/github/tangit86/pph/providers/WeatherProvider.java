package com.github.tangit86.pph.providers;

import com.github.tangit86.pph.domain.LocationDto;
import com.github.tangit86.pph.domain.UnitEnum;

public interface WeatherProvider {
    ProviderResponseDto get(LocationDto locationDto, UnitEnum unit) throws Exception;
}
