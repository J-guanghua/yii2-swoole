# AsyncTask 异步任务服务器

异步任务服务器是处理耗时任务的首选。

## 示例

此扩展中实现了一个简单的异步任务处理器 [`src/Commands/AsyncTaskController.php`](/src/Commands/AsyncTaskController.php)。

同时实现了 [`src/Handlers/SendEmailTaskHandler.php`](/src/Handlers/SendEmailTaskHandler.php)，一个模拟发送邮件的任务处理类。

示例中通过命令 `php swoolectl async-task/send-emails` 向异步任务服务器发送任务数据，告知异步任务服务器发送邮件，其中： `handler` 
任务处理程序，`email` 收件人，`subject` 邮件主题，`body` 邮件内容。

异步任务处理器接受到发送过来的 `json` 数据，解析为 PHP 数组，并将任务交付给 `TaskWorker` 处理，在 `TaskWorker` 接到任务后，根据
其中的 `handler` 创建任务处理类的对象并执行，然后 `TaskWorker` 通过 `finish` 告知 `Worker` 任务处理结果。
 
### 启动 AsyncTask 异步任务服务器

执行如下命令：

```bash
php swoolectl async-task/start
```

![Async Task 启动](/docs/guide/images/async-task-start.png)

### 模拟发送邮件

执行如下命令：

```bash
php swoolectl async-task/send-emails
```

服务器端显示如下

![Async Task 处理模拟发送邮件任务](/docs/guide/images/async-task-processing.png)
