package com.github.tangit86.pph.domain;

import java.util.Arrays;
import java.util.List;

public class LocationDto {

    public String city;
    public String countryCode;

    public LocationDto() {
    }

    public LocationDto(String city, String countryCode) {
        this.city = city;
        this.countryCode = countryCode;
    }

    public LocationDto(String location) throws Exception {
        String exp = "[a-zA-Z ]{3,30},[a-zA-Z]{2,3}";
        location = location.trim();

        if (!location.matches(exp)) {
            throw new Exception("Location not valid");
        }
        List<String> items = Arrays.asList(location.split(","));
        this.city = items.get(0);
        this.countryCode = items.get(1);
    }

    @Override
    public String toString() {
        return city + "," + countryCode;
    }
}
