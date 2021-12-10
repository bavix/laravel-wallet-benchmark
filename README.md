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
* **Database**: MySQL 8.0.27 (arm64 in Docker)
* **PHP**: 8.1.0 (arm64 native), pcov 1.0.10

| Name | 6.0.4 | 6.1.0 | 6.2.4 | 7.0.0 | 7.1.0 | 7.2.0 | 7.3.0-beta1 |
| --- | --- | --- | --- | --- | --- | --- |-------------|
| StateTest::testInTransaction   | 32.14786s    | 32.303855s |  33.251291s |  31.092385s |  17.634431s |  17.448182s | 17.819701s  |
| CartTest::testPay              | 29.691725s   | 29.12693s  |  48.218735s |  22.838637s |  26.92567s  |  26.737613s | 27.219126s  |
| CartTest::testPayFree          | 36.64304s    | 36.592076s |  53.359392s |  21.662551s |  25.108906s |  25.316395s | 25.363622s  |
| SoloTest::testGetBalance       | 5.253109s    | 5.243846s  |  5.609912s  |  5.486865s  |  5.523286s  |  5.56334s   | 5.968448s   |
| SoloTest::testDeposit          | 2.513897s    | 2.521361s  |  2.68477s   |  2.546184s  |  2.688301s  |  2.616405s  | 2.757482s   |
| SoloTest::testForceWithdraw    | 2.527576s    | 2.532933s  |  2.675782s  |  2.552193s  |  2.620756s  |  2.617255s  | 2.730251s   |
| SoloTest::testTransfer         | 4.992439s    | 4.860993s  |  5.081162s  |  4.682521s  |  4.726544s  |  4.768472s  | 4.944284s   |

The pivot table was generated with the [junit-reporter](https://github.com/bavix/junit-reporter)

---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
