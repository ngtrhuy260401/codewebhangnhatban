<?php 
error_reporting(0);
$password = '12345678';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Danh sách đăng ký</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.bootstrap.min.css">
	<script type="text/javascript">
		$(document).ready(function() {
			var table = $('#example').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
				"order": [[ 0, "desc" ]],
				"pageLength":1000
			} );
			table.buttons().container()
			.appendTo( '#example_wrapper .col-sm-6:eq(0)' );
		});
	</script>
</head>
<body>

	<?php  if(!isset($_POST) || !isset($_POST['password']) || $_POST['password'] != $password) { ?>
		<div style="width: 500px;margin: auto;margin-top: 80px;background: #f5f5f5;padding: 30px;border: 1px #ccc solid;max-width: 90%;">
			<form action="./ds.php" method="post">
				<p style="text-align: center;font-size: 17px;font-weight: 600;color: #001a52;margin-bottom: 10px">Vui lòng nhập mật khẩu để xem dữ liệu:</p>
				<div class="form-group" style="margin: 0;">
					<input type="password" name="password" class="form-control" style="margin-bottom: 10px;">
					<button type="submit" style="margin: auto;width: 100%;background: #001a52;color: #fff;border-radius: 4px;border: none;padding: 7px;">Đăng nhập</button>
				</div>
				<?php  if(isset($_POST) && isset($_POST['password']) && $_POST['password'] != $password) {
					echo '<p style="margin-top: 10px;text-align: center;font-weight: bold;color: red;">Mật khẩu không đúng!</p>';
				} ?> 
			</form>
		</div>
	<?php   }else {
		$json = file_get_contents('ds-data.txt');
		$json = explode("||", $json);

		?> 
		<div class="" style="padding:30px">
			<h2>Danh sách đăng ký</h2>

			<?php
			if(empty($json[0])){
				echo '<p>Chưa có ai đăng kí</p>';
			}else{
				$i=1;

				echo '<table id="example" class="table table-striped table-bordered">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>STT</th>';
				echo '<th>Địa chỉ IP</th>';
				echo '<th>Thời gian</th>';
				echo '<th>Thiết bị</th>';
				echo '<th>Nguồn UTM</th>';
				echo '<th>Trang đang xem</th>';
				echo '<th>Name</th>';
				echo '<th>Phone</th>';
				echo '<th>CCCD</th>';
				echo '<th>Address</th>';
				echo '<th>Giải thưởng</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';

				$giaithuong = [
					'Gấu bông NCB',
					'Balo du lịch NCB',
					'Box quà tặng',
					'Áo mưa NCB',
					'Ly Lock & Lock'
				];

				foreach ($json as $j) {
					$values = [];
					$j = (array)json_decode($j);
				// if(!empty($j) && $j['ip']!='127.0.0.1' && $j['action']!='Truy cập trang web'){
					if(!empty($j)){
						echo '<tr>';
						echo '<td>'.htmlspecialchars($i++).'</td>';
						echo '<td>'.htmlspecialchars($j['ip']).'</td>';
						echo '<td>'.htmlspecialchars($j['time']).'</td>';
						echo '<td>'.htmlspecialchars($j['device']).'</td>';
						echo '<td>'.htmlspecialchars($j['utm']).'</td>';
						echo '<td><a href="'.htmlspecialchars($j['currenturl']).'" style="font-size: 10px;word-break: break-all;max-width: 200px;overflow: hidden;display: block;">'.htmlspecialchars($j['currenturl']).'</a></td>';
						echo '<td>'.htmlspecialchars($j['name']).'</td>';
						echo '<td>'.htmlspecialchars($j['phone']).'</td>';
						echo '<td>'.htmlspecialchars($j['cccd']).'</td>';
						echo '<td>'.htmlspecialchars($j['address']).'</td>';
						if(isset($giaithuong[$j['giaithuong']])){
							echo '<td>'.htmlspecialchars($giaithuong[$j['giaithuong']]).'</td>';
						}else{
							echo '<td></td>';
						}
						echo '</tr>';
					}
				}

				echo '</tbody>';
				echo '</table>';
			}
			?>
		</div>
	<?php } ?> 
</body>
</html>
