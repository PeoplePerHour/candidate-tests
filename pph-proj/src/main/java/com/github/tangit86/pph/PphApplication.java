package com.github.tangit86.pph;

import io.katharsis.spring.boot.v3.KatharsisConfigV3;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Import;
import org.springframework.scheduling.annotation.EnableScheduling;

@Import(KatharsisConfigV3.class)
@EnableScheduling
@SpringBootApplication
public class PphApplication {

    public static void main(String[] args) {
        SpringApplication.run(PphApplication.class, args);
    }

}
