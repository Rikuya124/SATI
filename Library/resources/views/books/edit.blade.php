@extends('layouts.app')

@section('content')
  <h1>資料情報更新</h1>
  @include('commons.flash')
  <form action="{{ route('books.update', $book->id) }}" method="post" name = "contact_form">
    @method('patch')
    @csrf
    <dl>
      <dt>ISBN</dt>
      <dd>
          <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}">
      </dd>
      <dt>資料名</dt>
      <dd>
          <input type="text" name="title" value="{{ old('title', $book->title) }}">
      </dd>
      <dt>分類コード </dt>
      <dd>
          <select name="classify_id">
              <option value="0">総記</option>
              <option value="1">哲学</option>
              <option value="2">歴史</option>
              <option value="3">社会科学</option>
              <option value="4">自然科学</option>
              <option value="5">技術</option>
              <option value="6">産業</option>
              <option value="7">芸術</option>
              <option value="8">言語</option>
              <option value="9">文学</option>

          </select>
      </dd>
      <dt>著者</dt>
      <dd>
          <input type="text" name="author" value="{{ old('author', $book->author) }}">
      </dd>
      <dt>出版社</dt>
      <dd>
          <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}">
      </dd>
      <dt>出版日</dt>
      <dd>
      <?php
        preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/',$book->publish_date, $publish_date_match);
      ?>
          <input type="text" name="publish_date" value="{{ old('publish_date', $publish_date_match[0]) }}">
      </dd>
    </dl>
    <button onclick = "editBook()" name = "check">更新</button>
  </form>
  <form action="{{ route('books.show', $book) }}" method="get">
    <button>キャンセル</button>
  </form>
  <script>
        //[確認]ボタンが押されたときの処理を定義
       function editBook() {
            //input要素（name属性がisbn）の入力内容を取得
            const isbn = contact_form.isbn.value;
            const title = contact_form.title.value;
            const classify_id = contact_form.classify_id.value;
            const author = contact_form.author.value;
            const publisher = contact_form.publisher.value;
            const publish_date = contact_form.publish_date.value;
            event.preventDefault();
            if (confirm('以下の入力で正しいですか？\n' + "ISBN番号" + isbn + "\n"
                    + "資料名:" + title +"\n" 
                    + "分類コード:" + classify_id + "\n" 
                    + "著者:" + author + "\n"
                    + "出版社:" + publisher + "\n"
                    + "出版日:" + publish_date)
        ) {
                contact_form.submit();
            }
        }
        
        ;
    </script>
@endsection