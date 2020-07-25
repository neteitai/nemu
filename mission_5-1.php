<!doctype html>
<html lang="ja">
<head>
	<meta charset="utf-8">
<title>mission5-1</title>
</head>
	<body>
		<form action="" method="POST">
							名前：<input type="text" name="name" placeholder="名前を入力してください"><p>
							コメント：<input type="text" name="comment" placeholder="コメントを入力してください">
							<input type="hidden" name="rewnum2" placeholder="編集番号指定用フォーム"><p>
							パスワード：<input type="text" name="compassword" placeholder="パスワードを入力してください" value=""><p>
							<input type="submit" name="comsubmit"><br><br>
					</form>

		<form action="" method="post">
									削除対象番号：<input type="text" name="delete" placeholder="削除番号を入力してください"><p>
									パスワード：<input type="text" name="depassword" placeholder="パスワードを入力してください" value=""><p>
									<input type="submit" name="desubmit" value="削除"><br><br>
		</form>
		<form action="" method="post">
									編集対象番号：<input type="text" name="rewnum1" placeholder="編集対象番号を入力"><p>
									名前：<input type="text" name="rename" placeholder="名前を編集してください"><p>
									コメント：<input type="text" name="recomment" placeholder="コメントを編集してください"><p>
									パスワード：<input type="text" name="repassword" placeholder="パスワードを入力してください" value=""><p>
									<input type="submit" name="resubmit"value="編集"><br>
		</form>

			<?php


			$dsn = 'データベース名';
			$user = 'ユーザー名';
			$password = 'パスワード';
			$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブルを作成
			$sql = "CREATE TABLE IF NOT EXISTS tbtest"
			." ("
			. "id INT AUTO_INCREMENT PRIMARY KEY,"
			. "name char(32),"
			. "comment TEXT,"
			."date DATE,"
			."password TEXT"
			.");";
			$stmt = $pdo->query($sql);

//入力
	if(!empty($_POST['comsubmit'])){
				 if(!empty($_POST['name'])&&!empty($_POST['comment'])&&!empty($_POST['compassword'])){
			$password=$_POST["compassword"];

			$sql = $pdo -> prepare("INSERT INTO onepiece (name, comment,date,password) VALUES (:name, :comment,:date,:compassword)");
			$sql -> bindParam(':name', $name, PDO::PARAM_STR);
			$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql -> bindParam(':date', $date, PDO::PARAM_STR);
			$sql -> bindParam(':compassword', $password, PDO::PARAM_STR);
			$name = $_POST["name"];
			$comment =$_POST["comment"];
			$date = date("Y/m/d H:i:s");
			$sql -> execute();
	}
	}

//編集
if(!empty($_POST['resubmit'])){
			if(!empty($_POST['rename'])&&!empty($_POST['recomment'])&&!empty($_POST['repassword'])){
					 $password=$_POST["repassword"];
					 $id=$_POST["rewnum1"];
		 $name=$_POST["rename"];
		 $comment=$_POST["recomment"];

							$sql = 'update onepiece set name=:name,comment=:comment where id=:id AND password=:password';
							$stmt = $pdo->prepare($sql);
							$stmt->bindParam(':name', $name, PDO::PARAM_STR);
							$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
							$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);
							$stmt->execute();
					 }
			}

//削除
			if(!empty($_POST['desubmit'])){
			if(!empty($_POST['delete'])&&!empty($_POST['depassword'])){
							$password=$_POST["depassword"];
							$id = $_POST["delete"];
							$sql = 'delete from onepiece where id=:id AND password=:password';
							//$sql = 'delete from onepiece where id=:id';
							$stmt = $pdo->prepare($sql);
							$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);
							$stmt->execute();
					 }
					}
	$sql = 'SELECT * FROM onepiece';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].',';
			echo $row['date'].'<br>';
	echo "<hr>";
}

?>
        </body>
    </html>
