# WebSocket

通过 WebSocket 技术可以实现即时消息通讯，使用 Swoole 可以非常快捷的创建一个简单的 WebSocket 服务器。

## 示例代码

示例中实现了一个简单的实时通讯。

![简单 WebSocket 实时通讯](/docs/guide/images/example-websocket.gif)

### 启动 WebSocket 服务器

使用命令启动:

```bash
php console websocket/start
```

### 启动 Web 服务器 

示例中使用了 Yii console 的 `serve` 命令:

```bash
php console serve 0.0.0.0
```

启动后，使用浏览器打开地址 `http://<你的服务器IP>:8080/`，在消息框输入消息，点击发送就可以看到消息了，当其他人或打开一个新的相同页面，
就可以相互发送消息了。

这里只是一个简单的群发消息，将发送的消息发送到所有已连接的客户端中。

示例代码参见 [`example`](https://github.com/iPaya/yii2-swoole/tree/master/example).
