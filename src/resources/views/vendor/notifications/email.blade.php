@component('mail::message')
# メール認証のお願い

登録していただいたメールアドレスに認証リンクを送信しました。  
メールをご確認ください。

@component('mail::button', ['url' => $actionUrl])
認証はこちらから
@endcomponent

もしボタンがクリックできない場合は、以下のURLをコピーしてブラウザに貼り付けてください：

{{ $actionUrl }}

@endcomponent
