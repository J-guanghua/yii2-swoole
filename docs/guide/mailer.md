# 邮件发送服务器

通过定时器，每隔 1 秒钟扫描一次邮件队列，有邮件需要发送的邮件时，遍历所有需要发送的邮件，将发送邮件任务添加到 `TaskWorker` 中。
`TaskWorker` 根据发送来的数据执行发送邮件。

发送邮件时，将需要发送的邮件数据推送到队列中。

## 启动

执行命令:

```bash
php swoolectl mailer/start
```

![启动邮件发送服务器](/docs/guide/images/mailer-start.png)

## 发送

在这里实现了一个发送邮件的命令行命令 [Commands/ExampleController::actionTryMailer](/src/Commands/ExampleController.php), 
它实现了向邮件队列推送 4 条简单的邮件信息。
