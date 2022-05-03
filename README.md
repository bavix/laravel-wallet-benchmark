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
* **PHP**: 8.1.5 (arm64 native), pcov 1.0.11

|          Name          |    6.x.x    |    7.x.x    |    8.x.x    |    9.x.x    |
|------------------------|-------------|-------------|-------------|-------------|
| Cart:EagerLoaderPay    | 54.629752s  | 49.613899s  | 1.618865s   | 1.115148s   |
| Cart:Pay               | 3.71251716s | 2.479592s   | 1.10196812s | 787.97172ms |
| Cart:PayFree           | 3.91352972s | 2.35673068s | 1.1963396s  | 767.4488ms  |
| Cart:PayOneItemXPieces | 1.90393404s | 1.0040618s  | 300.46176ms | 81.83716ms  |
| Solo:Deposit           | 36.41504ms  | 45.27616ms  | 44.30149ms  | 39.76877ms  |
| Solo:EagerLoading      | 2.18375652s | 8.96233848s | 2.95431568s | 2.735177s   |
| Solo:ForceWithdraw     | 35.92262ms  | 45.36723ms  | 43.74567ms  | 40.13479ms  |
| Solo:GetBalance        | 22.191416ms | 22.820876ms | 23.800013ms | 24.496166ms |
| Solo:Transfer          | 75.44347ms  | 93.17037ms  | 91.80417ms  | 75.48488ms  |
| State:InTransaction    | 1.6373984s  | 1.18124788s | 1.16913928s | 1.1686232s  |

The pivot table was generated with the [junit-reporter](https://github.com/bavix/junit-reporter)

---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
