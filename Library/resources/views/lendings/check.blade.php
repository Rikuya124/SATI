@extends('layouts.app')

@section('content')
<h1>貸出確認画面</h1>
@if($book)
<div class="documents">
  <h2>会員情報</h2>
  <form action="{{ route('lendings.store', $customer->id) }}" method="post" name="contact_form">
    @csrf
      <dl>
        <dt>会員ID</dt>
        <dd>
          <p>{{ $customer->id }}</p>
          <input type="hidden" name="cust_id" value="{{ $customer->id }}">
        </dd>
        <dt>会員名</dt>
        <dd>
          <p>{{ $customer->name }}</p>
        </dd>
      </dl>
   
      <h2>資料情報</h2>
      <dl>
        <dt>資料ID</dt>
        <dd>
          <p>{{ $book->id }}</p>
          <input type="hidden" name="book_id" value="{{ $book->id }}">
        </dd>
        <dt>資料名</dt>
        <dd>
          <p>{{ $book->title }}</p>
        </dd>
        <dt>著者</dt>
        <dd>
          <p>{{ $book->author }}</p>
        </dd>
        <dt>出版社</dt>
        <dd>
          <p>{{ $book->publisher }}</p>
        </dd>
      </dl>
  </div>
 
  <?php
    $today = date('Y-m-d');
    if(strtotime($book->publish_date) > strtotime("-3 month")){
      //出版日($book->publish_date)が本日から3ヶ月以内
      $expectied_date = date("Y-m-d", strtotime("10 day"));
    }else{
      $expectied_date = date("Y-m-d", strtotime("15 day"));
    }

  ?>
   <div class="documents">
      @if($book->lendings->whereNull('return_date')->count())
      <p class="msg">この本は現在貸出中です</p>
      <a href="{{route('customers.show',$customer)}}">会員詳細画面に戻る</a>
      @elseif(isset($book->trash_date))
      <p class="msg">この本は廃棄済みです。</p>
      <a href="{{route('customers.show',$customer)}}">会員詳細画面に戻る</a>
      @else
 
    <dl>
    <dt>貸出日</dt>
      <dd>{{ $today }}</dd>
      <input type="hidden" name="lend_date" value="{{ $today }}">
    <dt>返却予定日</dt>
      <dd>{{ $expectied_date }}</dd>
    </dl>
  
    <div class="button_line004">
      <input type="hidden" name="expectied_date" value="{{ $expectied_date }}">
      <button onclick="lendBook()" class="btn2">貸出する</button>
    </form>
    </div>
  </div>
  <script>
        //[確認]ボタンが押されたときの処理を定義
       function lendBook() {
            //input要素の入力内容を取得
            const id = "{{$customer->id}}";
            const name = "{{$customer->name}}";
            const book_id = "{{$book->id}}";
            const title = "{{$book->title}}";
            const author = "{{$book->author}}";
            const publisher = "{{$book->publisher}}";
            const expectied_date = "{{$expectied_date}}";
            event.preventDefault();
            if (confirm('以下の資料を貸出しますか？\n' + "会員ID:" + id + "\n"
                    + "氏名:" + name +"\n"
                    + "資料ID:" + book_id +"\n"
                    + "資料名:" + title + "\n"
                    + "著者:" + author + "\n"
                    + "出版社:" + publisher + "\n"
                    + "返却予定日:" + expectied_date )
        ) {
                contact_form.submit();
            }
        }
        ;
    </script>
  @endif
@else
  <p class="msg">該当する資料が存在しません</p>
  <a href="{{route('customers.show',$customer)}}">会員詳細画面に戻る</a>
@endif
@endsection