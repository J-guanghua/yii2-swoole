# 毫秒级定时器

使用 Swoole 的 [`tick`](https://wiki.swoole.com/wiki/page/414.html) 实现。

## 示例

代码中的 [`src/Commands/MillisecondTimerController.php`](/src/Commands/MillisecondTimerController.php) 实现了一个简单的定时器，
每隔 `5` 秒会执行一个 Yii Console 应用的命令 `say/something "Hello World"`, 它会在命令行输出 `Hello World`。

![毫秒级定时器](/docs/guide/images/millisecond-timer-example.png)
