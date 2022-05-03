laravel-wallet-benchmark - A special project for testing performance from version to version of the laravel-wallet package.

[![phpunits](https://github.com/bavix/laravel-wallet-benchmark/actions/workflows/phpunits.yaml/badge.svg)](https://github.com/bavix/laravel-wallet-benchmark/actions/workflows/phpunits.yaml)

* **Vendor**: bavix
* **Project**: laravel-wallet-benchmark
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
| Cart:EagerLoaderPay    | 58.949697s  | 49.58581s   | 1.466579s   | 1.032154s   |
| Cart:Pay               | 4.08699296s | 2.50341516s | 1.03995896s | 721.67092ms |
| Cart:PayFree           | 4.15599512s | 2.36554972s | 1.01579044s | 631.9784ms  |
| Cart:PayOneItemXPieces | 2.0559186s  | 1.01231272s | 252.7258ms  | 83.73056ms  |
| Solo:Deposit           | 38.18582ms  | 36.67559ms  | 37.35399ms  | 35.68319ms  |
| Solo:EagerLoading      | 2.13623892s | 8.82851804s | 2.30754092s | 2.14806152s |
| Solo:ForceWithdraw     | 38.39115ms  | 36.87102ms  | 37.52448ms  | 35.47786ms  |
| Solo:GetBalance        | 23.543576ms | 24.199633ms | 23.38236ms  | 23.888203ms |
| Solo:Transfer          | 78.80488ms  | 72.01921ms  | 72.81176ms  | 59.42262ms  |
| State:InTransaction    | 1.82724428s | 766.2884ms  | 771.08604ms | 767.08376ms |

The pivot table was generated with the [junit-reporter](https://github.com/bavix/junit-reporter)

---
Supported by

[![Supported by JetBrains](https://cdn.rawgit.com/bavix/development-through/46475b4b/jetbrains.svg)](https://www.jetbrains.com/)
