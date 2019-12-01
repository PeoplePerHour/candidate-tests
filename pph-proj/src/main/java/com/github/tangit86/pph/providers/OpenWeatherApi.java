package com.github.tangit86.pph.providers;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.github.tangit86.pph.domain.LocationDto;
import com.github.tangit86.pph.domain.UnitEnum;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Component;
import org.springframework.web.client.RestTemplate;
import org.springframework.web.util.UriComponentsBuilder;

@Component("openWeatherApi")
public class OpenWeatherApi implements WeatherProvider {

    @Autowired
    RestTemplate restTemplate;

    @Value("${openweather.apikey}")
    String apiKey;

    @Value("${openweather.host}")
    String host;

    @Override
    public ProviderResponseDto get(LocationDto locationDto, UnitEnum unit) throws Exception {
        String url = host + "data/2.5/weather";

        UriComponentsBuilder builder = UriComponentsBuilder.fromHttpUrl(url)
                .queryParam("q", locationDto.toString())
                .queryParam("appid", apiKey)
                .queryParam("units", map(unit));

        String response = restTemplate.getForObject(builder.toUriString(), String.class);

        return parseResponse(response);
    }

    private ProviderResponseDto parseResponse(String response) throws JsonProcessingException {
        JsonNode weatherNode = new ObjectMapper().readTree(response);
        ProviderResponseDto result = new ProviderResponseDto();
        result.description = weatherNode.get("weather").get(0).get("main").asText();
        result.temperature = weatherNode.get("main").get("temp").asDouble();
        return result;
    }

    private String map(UnitEnum unitEnum) throws Exception {
        if (unitEnum == UnitEnum.Celsius) {
            return "metric";
        } else if (unitEnum == UnitEnum.Fahrenheit) {
            return "imperial";
        } else {
            throw new Exception("Not supported Temperature Unit system");
        }
    }
}


