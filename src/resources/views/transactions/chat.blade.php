@extends('layouts.simple')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
<div class="chat-wrapper">

    {{-- 左サイドバー --}}
    <aside class="chat-sidebar">
        <h3>取引中の商品</h3>
        <ul>
            @foreach($ongoingTransactions as $t)
                <li>
                    <a href="{{ route('transactions.chat', $t->id) }}">
                        {{ $t->item->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    {{-- メインエリア --}}
    <main class="chat-main">

        {{-- 上部：相手情報 --}}
        <div class="chat-header">
            <div class="user-info">
                <img src="{{ $partner->icon ? asset('storage/' . $partner->icon) : asset('images/default-icon.png') }}" class="user-icon">
                <span>{{ $partner->name }} さんとの取引画面</span>
            </div>

            {{-- 購入者のみ取引完了ボタン --}}
            @if (auth()->id() === $transaction->buyer_id)
            <form action="{{ route('transactions.finish', $transaction->id) }}" method="POST">
                @csrf
                <button class="finish-btn">
                    取引を完了する
                </button>
            </form>
            @endif
            
        </div>

        {{-- 商品情報 --}}
        <div class="item-info">
            <img src="{{ asset('storage/' . $transaction->item->img_url) }}" class="item-image">
            <div>
                <p class="item-name">{{ $transaction->item->name }}</p>
                <p class="item-price">¥{{ number_format($transaction->item->price) }}</p>
            </div>
        </div>

        {{-- チャット欄 --}}
        <div class="chat-messages">
            @foreach($messages as $message)
                <div class="chat-message-row 
                    {{ $message->sender_id === auth()->id() ? 'mine' : 'theirs' }}">
                    
                    <div class="chat-user-info">
                        @if ($message->sender_id !== auth()->id())
                            <img src="{{ asset('storage/' . $message->sender->icon) }}" class="chat-user-icon">
                            <p class="sender-name">{{ $message->sender->name }}</p>
                        @else
                            <p class="sender-name">{{ $message->sender->name }}</p>
                            <img src="{{ asset('storage/' . auth()->user()->icon) }}" class="chat-user-icon">
                        @endif
                    </div>
                    
                    <div class="message-buble">
                        {{ $message->message }}
                    </div>

                    @if ($message->sender_id === auth()->id())
                        <div class="message-actions">
                            <button class="edit-btn"
                                onclick="openEditForm({{ $transaction->id }}, {{ $message->id }}, '{{ $message->message }}')">
                                編集
                            </button>

                            <form action="{{ route('messages.destroy', [$transaction->id, $message->id]) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn" onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- メッセージ入力欄 --}}
        @if ($errors->any())
            <div class="error-messages">
                @foreach ($errors->all() as $error)
                    <p class="error-text">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form action="{{ route('transactions.chat.send', $transaction->id) }}" method="POST" enctype="multipart/form-data" class="chat-input-area">
            @csrf

            {{-- 入力保持（old() で実現） --}}
            <textarea name="message" placeholder="取引メッセージを記入してください">{{ old('message') }}</textarea>

            {{-- 画像追加 --}}
            <label class="image-upload">
                画像を追加
                <input type="file" name="image" accept="image/*">
            </label>

            {{-- 送信ボタン（紙飛行機アイコン） --}}
            <button class="send-btn">
                <img src="{{ asset('images/send-icon.jpg') }}" alt="送信" class="send-icon">
            </button>
        </form>

    </main>

</div>

<div id="editModal" class="edit-modal" style="display:none;">
    <form id="editForm" method="POST">
        @csrf
        @method('PATCH')

        <textarea name="message" id="editMessage" rows="3"></textarea>

        <button type="submit">更新</button>
        <button type="button" onclick="closeEditForm()">キャンセル</button>
    </form>
</div>

<script>
function openEditForm(transactionId, messageId, message) {
    document.getElementById('editModal').style.display = 'block';
    document.getElementById('editMessage').value = message;
    document.getElementById('editForm').action =
        `/transactions/${transactionId}/messages/${messageId}`;
}

function closeEditForm() {
    document.getElementById('editModal').style.display = 'none';
}
</script>

<div id="ratingModal" class="rating-modal" style="display:none;">
    <div class="rating-modal-content">

        <p class="rating-title">取引が完了しました。</p>
        <div class="rating-divider"></div>
        <p class="rating-subtitle">今回の取引相手はどうでしたか？</p>

        <form action="{{ route('transactions.rate', $transaction->id) }}" method="POST">
            @csrf

            <div class="star-rating">
                <input type="radio" name="rating" id="star5" value="5">
                <label for="star5">★</label>

                <input type="radio" name="rating" id="star4" value="4">
                <label for="star4">★</label>

                <input type="radio" name="rating" id="star3" value="3">
                <label for="star3">★</label>

                <input type="radio" name="rating" id="star2" value="2">
                <label for="star2">★</label>

                <input type="radio" name="rating" id="star1" value="1">
                <label for="star1">★</label>
            </div>
            <div class="rating-divider"></div>

            <button type="submit" class="rating-submit-btn">送信する</button>
            <button type="button" class="rating-cancel-btn" onclick="closeRatingModal()">キャンセル</button>
        </form>

    </div>
</div>

<script>
    function openRatingModal() {
        document.getElementById('ratingModal').style.display = 'flex';
    }

    function closeRatingModal() {
        document.getElementById('ratingModal').style.display = 'none';
    }
</script>

@if ($transaction->buyer_finished && !$transaction->seller_rating)
    <script>
        window.onload = function() {
            openRatingModal();
        };
    </script>
@endif

@endsection