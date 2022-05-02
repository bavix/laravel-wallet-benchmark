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

| Name                            | 6.2.4        | 7.3.3        | 8.4.1      | 9.0.0      |
|---------------------------------|--------------|--------------|------------|------------|
| CartTest::testPay               | 1m41.859842s | 1m1.982956s  | 17.412438s | 17.094677s |
| CartTest::testPayFree           | 1m42.212257s | 58.135556s   | 14.877622s | 15.059677s |
| CartTest::testPayOneItemXPieces | 50.633988s   | 24.711588s   | 2.007424s  | 2.096698s  |
| SoloTest::testGetBalance        | 6.807218s    | 6.58099s     | 7.058258s  | 7.06993s   |
| SoloTest::testEagerLoading      | 52.66466s    | 3m40.334665s | 53.098282s | 52.838576s |
| SoloTest::testTransfer          | 7.623928s    | 6.789149s    | 5.588853s  | 5.583658s  |
| StateTest::testInTransaction    | 44.217149s   | 18.415206s   | 18.405966s | 18.401289s |
| CartTest::testEagerLoaderPay    | 58.287831s   | 49.51261s    | 1.075221s  | 984.086ms  |
| SoloTest::testDeposit           | 3.617338s    | 3.48139s     | 3.389587s  | 3.414524s  |
| SoloTest::testForceWithdraw     | 3.595859s    | 3.48732s     | 3.420613s  | 3.384791s  |

The pivot table was generated with the [junit-reporter](https://github.com/bavix/junit-reporter)

---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
