<?php
return [
    //应用ID,您的APPID。
    'app_id' => "2016092500595522",

    //商户私钥
    'merchant_private_key' => "MIIEowIBAAKCAQEA0NyALgZ4EoIiny2AuLqz9qhgzEQfltyqlLrSUzkNtucCKuqfdCnKmiqewXb4Mjm/OyRHd72Bdx8ch9DR0TLdGbZ1xiGHf5qrOkHdb6qEXo111rsLbXZu+xREdBg6ue4ud4by4DMLK2pnEQpCrYVHXLEUbQ2GrQ37SnYESmRNJdoVulvkdaGIJSgj15CkAABjo8yFPdx8DmvLy8g2OJkS3F/DSv5JtGIWTn8ohFG3zezjY1fYsTPwGs1HQxKf8zhxxPF58tgE9JfvhwSLq66dvUsPfRI0rU9oITgegMzBfcGJoSq9OmHHD4L266myfnMwNBW610N+jWfAh78wkDmJuQIDAQABAoIBAQDCt7+8qQVKZA65DegC0PU0kRfld+FneYSCsoWhVwCFM2se7awI1WlwPynQvgR4dsPk9Fa4uHE5yESGDlV+Tog5D5VPSTUU7vKRlpRGJdfQetuQfMMToyWmaOfEwE4Hx5mEj8hg4tWX/VPnXAR711SHgwPDA6g6MF3Ftq8bV9Vg4feY/cxllM0M50+6kQGbGIMTeHiUp0Ylqpn1JFuWK7I4KwwE0PC0quNSkuIgOdYZsH2IK7eDbTX/WiVX02w51sCUoLXI1BJIKUbcjflSuJ4DSs5p4kpCSoQhq00mZjr3IZf3S4m9gkyoK2WWKmLHihwPiamcd4VlXLkMmvlo5/cNAoGBAPlwpq4a9t0u7l1/nDlx1J/zNXTq9PIS37RHf12PtBvfrTd0jZOGukvlHq9yypnfhvEYtKlbtHYDOwFSwhKqepz5jA0804lNQKrYt+flh51i7F3P/X7CuIVOqT3oEPrFrwt+bb35XqmIypKgDaCkj4VEMtyffimXuI59nR7VGwvDAoGBANZap4joFpfmH07/lQCr4qhvN3ZNQ/LTxw3Tlw55Do+J2+VSh3cEVPoXS6EbXas5yxtjQaHdaFez+fIZOMpmxD+ZJBxFSLpeELFynmtMovHOVLcC27OyjNY6EGnn4Sg9++VkgEwsHerlwGzE6pbOV6V7tqJpDmrQmDy20P+X4EjTAoGATlk08ZDko3q/Qjz37A82EvuIee3m/DYzb+PZPKELmIm8VaPVaFY0I+yWo9Mxkf1k3Eu/S0bTuxGuse61qLlFhBLaC7pkU0chncguk7dDzoqo5ZqT7AHrhWu8uwYudyYqojiW7cnrEuM1hbKiNSgbMGfIdgXe0d+nB5KrDGkxcpMCgYBu9oLfxnVbsM7oUDpMHK66zsgBP8I7BBJ5P91kqpo1CAKDVhO2MtHinQiTn9z/dG2GAf3J0xnevNZY02GotUZGPfqJf/xELcmqclE77nIzhsIn8xzUi0uI4on4qQbPlDa/6yTXScc7ADB6nf1qj+qjScWjkYrbFJyaYXETvwVl7QKBgD+S7Ln4xJWpUOPnpR1p1ATBnu2iTKAosf5YrZcSJ6jl3ZFIgxr3iPcJ+wE5RS7OfvfOiNAKtzVN6T10jkILW0BZdXXXVuMQx2t/ML1lhgPWrI0FYuw5FbKeZEdDniTBe8XzBkYSYEoevzAaQzPEuoqoejvSP1L1W9JJ8aQpxRjK",

    //异步通知地址
    'notify_url' => "http://localhost/alipay/notify_url.php",

    //同步跳转
    'return_url' => "http://www.mall.com/car/returnpay",
//同步跳转
//    'return_url' => "http://www.1809.com/goods/index",
    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqNiAmJaJrfGFZCvIEUmJLCnvMM4MPDboa3Orw3k1HZ2yYJ/A0FDNqbDiQwL0Z+SDqcs0ijAlkLbLzUQJwe1GGVgvEQzZchFVkR7wcQGt3EzCvYajL+KLm4+77gxQ+3vE7s5UKSei1I4h7rk9Xn4g+KobA38EZoDrtHCmesXLUrvQHWeNEs3en/rnJqxgDaEBo1rXPDpom8MmKdAm8s8RkJ5mmhIhBulBdPSG2Qlrpio2vvy1IIbxdh+fsTs8ixfRFo16JScMiF3QSnMg9jeCcGcmxK4al+3iSqH14ukfcezGd3dDxRUfO0INuvRbS1KrinLhZbP6TnxV0UMDh+71NQIDAQAB",
];