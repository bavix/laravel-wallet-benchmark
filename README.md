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
* **PHP**: 8.1.5 (arm64 native), pcov 1.0.10

| Name                            | 7.3.3        | 8.4.1      | 9.0.0-RC2  | 
|---------------------------------|--------------|------------|------------|
| SoloTest::testTransfer          | 7.377002s    | 6.191329s  | 6.193337s  |   
| CartTest::testPay               | 1m2.617071s  | 17.704644s | 17.844328s | 
| SoloTest::testGetBalance        | 7.040529s    | 7.251735s  | 7.233609s  |
| SoloTest::testDeposit           | 3.773541s    | 3.667777s  | 3.664601s  |
| SoloTest::testEagerLoading      | 3m44.977786s | 56.706156s | 56.982445s |
| SoloTest::testForceWithdraw     | 3.744525s    | 3.645576s  | 3.661481s  |
| StateTest::testInTransaction    | 20.0454s     | 20.319753s | 20.186998s |
| CartTest::testEagerLoaderPay    | 50.897568s   | 1.127517s  | 1.058022s  |
| CartTest::testPayFree           | 59.590283s   | 16.438188s | 16.435098s |
| CartTest::testPayOneItemXPieces | 25.354979s   | 2.030466s  | 2.107291s  |

The pivot table was generated with the [junit-reporter](https://github.com/bavix/junit-reporter)

---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
