[![Package Rank](https://phppackages.org/p/bavix/laravel-wallet-benchmark/badge/rank.svg)](https://packagist.org/packages/bavix/laravel-wallet-benchmark)
[![Latest Stable Version](https://poser.pugx.org/bavix/laravel-wallet-benchmark/v/stable)](https://packagist.org/packages/bavix/laravel-wallet-benchmark)
[![Latest Unstable Version](https://poser.pugx.org/bavix/laravel-wallet-benchmark/v/unstable)](https://packagist.org/packages/bavix/laravel-wallet-benchmark)
[![License](https://poser.pugx.org/bavix/laravel-wallet-benchmark/license)](https://packagist.org/packages/bavix/laravel-wallet-benchmark)
[![composer.lock](https://poser.pugx.org/bavix/laravel-wallet-benchmark/composerlock)](https://packagist.org/packages/bavix/laravel-wallet-benchmark)

laravel-wallet-benchmark - A special project for testing performance from version to version of the laravel-wallet package.

* **Vendor**: bavix
* **Package**: laravel-wallet-benchmark
* **Version**: [![Latest Stable Version](https://poser.pugx.org/bavix/laravel-wallet-benchmark/v/stable)](https://packagist.org/packages/bavix/laravel-wallet-benchmark)
* **PHP Version**: 8.0+ 
* **Laravel Version**: `6.x`, `7.x`, `8.x`
* **[Composer](https://getcomposer.org/):** `composer require bavix/laravel-wallet-benchmark`

---

### Let's move on to the numbers.

They often write that the new version is slower than the previous one, and sometimes this is true. To reduce such claims, I made this benchmark. Its essence is to cover the main functionality and run it many times. At the output, we get a run file and aggregate the data.

The main audience of the package works with mysql, so I will be testing on mysql. Perhaps in the future, I will make configs for gitlab actions and everything will be inside the job, but now there is no time for that.

Let's move on to the run configuration.

* **Hardware**: MacBook Pro 13' 2020. Apple M1
* **Memory**: 16GB
* **Lock Provider**: redis
* **Cache Provider**: redis
* **Database**: MySQL 8.0.27 (amd64+rosetta 2 in Docker)
* **PHP**: 8.1.0 (arm64), pcov 1.0.10

| Name                         | 6.0.0 | 6.1.0 | 6.2.0 | 7.0.0 | 7.1.0-RC3 | 7.2.0-beta1 | 7.3.0-alpha |
|------------------------------| ----- | ----- | ----- | ----- | ----- | ----- | ----- |
| CartTest::testPayFree        |    48.874592s    |  1m0.752785s  |  1m9.851301s  |  29.375265s  |  32.792958s  |  33.050982s   |  33.019704s  |
| SoloTest::testGetBalance     |  8.029543s     |  8.111186s    |  7.13864s     |  7.156312s   |  7.231103s   |  7.230414s    |  7.766673s   |
| SoloTest::testDeposit        |   4.1173s       |  4.247349s    |  3.66482s     |  3.576762s   |  3.715531s   |  3.61955s     |  3.819309s   |
| SoloTest::testForceWithdraw  |  3.772913s     |  4.207173s    |  3.654626s    |  3.54428s    |  3.623086s   |  3.620779s    |  3.761648s   |
| SoloTest::testTransfer       |   10.049418s    |  8.9035s      |  7.651214s    |  7.054606s   |  7.204701s   |  7.213786s    |  7.406053s   |
| StateTest::testInTransaction |  1m20.595317s  |  53.196909s   |  50.214342s   |  41.509341s  |  26.363875s  |  25.959117s   |  25.930789s  |
| CartTest::testPay            |   1m7.062113s   |  54.811465s   |  59.989745s   |  30.714206s  |  35.002056s  |  35.071199s   |  35.191258s | 


---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
