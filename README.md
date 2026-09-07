
# PHP FCM sample for B4A

Send push notifications to your B4A (android) or B4I (ios) app.
This sample uses `kreait/firebase-php` and requires at least PHP 8.2.

# How to use

- Extract files from archive or clone this repo

- Download your `service_account.json` by following [this tutorial](https://www.b4x.com/android/forum/threads/b4x-firebase-push-notifications-2023.148715).

- Rename the file to `service_account.json` and copy it to this project folder

- Edit the notification destination in `example.php`, then run it with PHP, through a web server or from your terminal with the PHP CLI.

  ```bash
  php example.php
  ```

## Sending examples

`example.php` sends one B4A topic notification to `test_topic` by default.
Change it to your own topic before running it.

- Use a normal topic name, such as `test_topic`, for B4A.
- Prefix a B4I topic with `ios_`, for example `ios_test_topic`. This applies the
  iOS notification title/body, APNs priority `10`, default sound, and badge `0`.
- To send custom data, enable the alternative example that includes
  `array('action' => 'no_action')`. Each enabled call sends a separate
  notification, so only enable the one you intend to test.
- To send to one device, replace `XXXXXXXXXXXXXXXX` with its current FCM
  registration token and uncomment one token example. Set `$isIosDevice` to
  `true` for a B4I device.

Custom data must be a flat list of scalar values; FCM data payload values are
sent as strings.

## Do I need Composer or any extra tool to use the code?

No. This project includes the required PHP dependencies in `vendor/`, so B4X
developers can download the ZIP or clone the repository and run `php example.php`
without installing Composer.

Composer is only needed when you want to perform advanced maintenance, such as
updating or auditing the bundled PHP dependencies.

### PHP server requirements

Make sure that your PHP server has these PHP extensions enabled: `openssl`, `mbstring`, and
`sodium`.


## 💰 Support my work

MADE WITH ❤ by [PUNCHLINE TECHNOLOGIES](http://punchlinetech.com/)


[![Paystack](https://camo.githubusercontent.com/5d5adf9d54538e76036a7254f76aebd99beba70305ab0f4a8742bc296deded44/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f537570706f72742d506179737461636b2d3030633366373f7374796c653d666f722d7468652d6261646765266c6f676f3d70617970616c266c6f676f436f6c6f723d7768697465)](https://paystack.com/pay/rbhzwdgozj)

**LINK**: [https://paystack.com/pay/rbhzwdgozj](https://paystack.com/pay/rbhzwdgozj)



[![Flutterwave](https://camo.githubusercontent.com/9e69503c5c250c3874655958c03a7cfd715c32c87c82c24b2fb05645f7c8811e/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f537570706f72742d466c7574746572776176652d6666616130303f7374796c653d666f722d7468652d6261646765266c6f676f3d627566666572266c6f676f436f6c6f723d7768697465)](https://flutterwave.com/donate/xua1z1xmabji)

**LINK**: [https://flutterwave.com/donate/xua1z1xmabji](https://flutterwave.com/donate/xua1z1xmabji)

## Stay In Touch

[![LinkedIn](https://camo.githubusercontent.com/e2504679aab58d5458588da6bf14ccacc8cc4a7d8caf6512685f97e118aa503e/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f4c696e6b6564496e2d2532333030373742352e7376673f7374796c653d666c61742d737175617265266c6f676f3d6c696e6b6564696e266c6f676f436f6c6f723d7768697465)](https://www.linkedin.com/in/seyi-aderinkomi-923b75145/) [![Twitter](https://camo.githubusercontent.com/4f707646aac12e295974d5dc3013501950fd70c01f151b78764d92bb38538333/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f547769747465722d2532333144413146322e7376673f7374796c653d666c61742d737175617265266c6f676f3d54776974746572266c6f676f436f6c6f723d7768697465)](https://twitter.com/iamfrostcodes)

## License

[MIT](https://opensource.org/licenses/MIT)

Copyright (c) 2023-present, Oluwaseyi Aderinkomi
