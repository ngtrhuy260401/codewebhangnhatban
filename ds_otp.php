<?php 
error_reporting(0);
$password = 'Lp@bank';
$email = [
	'ihappy.asia@gmail.com',
	'tienndt@lpbank.com.vn',
	'hienkt@lpbank.com.vn',
	'suongdtt@lpbank.com.vn',
];
?>
<!DOCTYPE html>
<html class="ds1 "  lang="en">
<head class="ds2 " >
	<title class="ds3 " >Danh sách đăng ký</title>
	<meta class="ds4 "  charset="utf-8">
	<meta class="ds5 "  name="viewport" content="width=device-width, initial-scale=1">
	<link class="ds6 "  rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script class="ds7 "  src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script class="ds8 "  src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script class="ds9 "  src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
	<script class="ds10 "  src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
	<script class="ds11 "  src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.bootstrap.min.js"></script>
	<script class="ds12 "  src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script class="ds13 "  src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script class="ds14 "  src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
	<script class="ds15 "  src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
	<script class="ds16 "  src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
	<script class="ds17 "  src="//cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
	<link class="ds18 "  rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
	<link class="ds19 "  rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.bootstrap.min.css">
	<script class="ds20 "  type="text/javascript">
		$(document).ready(function() {
			var table = $('#example').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
				"order": [[ 0, "desc" ]],
				"pageLength":1000
			} );
			table.buttons().container().appendTo( '#example_wrapper .col-sm-6:eq(0)' );
		});
	</script>
</head>
<body class="ds21 " >

	<?php  if(!isset($_POST) || !isset($_POST['email']) || empty($_POST['email']) || !in_array($_POST['email'], $email) || !isset($_POST['password']) || empty($_POST['password']) || $_POST['password'] != $password) { ?>
		<div class="ds22 "  style="width: 500px;margin: auto;margin-top: 80px;background: #f5f5f5;padding: 30px;border: 1px #ccc solid;max-width: 90%;">
			<form class="ds23 "  action="./ds.php" method="post">
				<p class="ds24 "  style="text-align: center;font-size: 17px;font-weight: 600;color: #001a52;">Vui lòng nhập địa chỉ email và mật khẩu để xem dữ liệu:</p>
				<div class="ds25 form-group" style="margin: 0;">
					<input type="email" name="email" class="ds26 form-control" style="margin-bottom: 10px;" placeholder="Email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
					<input type="password" name="password" class="ds27 form-control" style="margin-bottom: 10px;" placeholder="Password" value="<?php if(isset($_POST['password'])){ echo $_POST['password']; } ?>">
					<button class="ds30 "  type="submit" style="margin: auto;width: 100%;background: #001a52;color: #fff;border-radius: 4px;border: none;padding: 7px;">Đăng nhập</button>
				</div>
				<?php  if(isset($_POST) && isset($_POST['email']) && !in_array($_POST['email'], $email)) {
					echo '<p class="ds31 "  style="margin-top: 10px;text-align: center;font-weight: bold;color: red;">Email của bạn không có trong danh sách email được phép đăng nhập!</p>';
				} ?> 
				<?php  if(isset($_POST) && isset($_POST['password']) && $_POST['password'] != $password) {
					echo '<p class="ds31 "  style="margin-top: 10px;text-align: center;font-weight: bold;color: red;">Mật khẩu không đúng!</p>';
				} ?> 
			</form>
		</div>

		<?php }elseif(!isset($_POST['otp']) || !isset($_POST['otpcheck']) || md5('lpbank'.$_POST['otp']) != $_POST['otpcheck']) { 
			$otp = rand(1111,9999);
			$otpCheck = md5('lpbank'.$otp);
			?>

			<div class="ds22 "  style="width: 500px;margin: auto;margin-top: 80px;background: #f5f5f5;padding: 30px;border: 1px #ccc solid;max-width: 90%;">
				<form class="ds23 "  action="./ds.php" method="post">
					<p class="ds24 "  style="text-align: center;font-size: 17px;font-weight: 600;color: #001a52;">Vui lòng nhập mã OTP được gửi về email <?php echo $_POST['email']; ?> (kiểm tra cả mục Spam):</p>
					<div class="ds25 form-group" style="margin: 0;">
						<input type="hidden" name="email" class="ds26 form-control email" style="margin-bottom: 10px;" placeholder="Email" value="<?php echo $_POST['email']; ?>">
						<input type="hidden" name="password" class="ds27 form-control" style="margin-bottom: 10px;" placeholder="Password" value="<?php echo $_POST['password']; ?>">
						<input type="hidden" name="otpcheck" class="ds27 form-control" style="margin-bottom: 10px;" placeholder="Password" value="<?php echo $otpCheck; ?>">
						<input type="text" name="otp" class="ds28 form-control" style="margin-bottom: 10px;" placeholder="OTP nhận được trong email">
						<button class="ds30 "  type="submit" style="margin: auto;width: 100%;background: #001a52;color: #fff;border-radius: 4px;border: none;padding: 7px;">Đăng nhập</button>
					</div>

					<?php  if(isset($_POST) && isset($_POST['otp']) && isset($_POST['otpcheck']) && md5('lpbank'.$_POST['otp']) != $_POST['otpcheck']) {
						echo '<p class="ds31 "  style="margin-top: 10px;text-align: center;font-weight: bold;color: red;">Mã OTP không đúng! Hệ thống đã gửi một mã OTP khác, vui lòng kiểm tra và điền lại.</p>';
					} ?> 
				</form>
			</div>

			<script type="text/javascript">
				$(document).ready(function() {
					$.ajax({
						dataType: "html",
						type: "POST",
						evalScripts: true,
						url: "//api.ihappy.vn/sendMail",
						data: ({to:'<?php echo $_POST['email']; ?>',url:window.location.hostname,html:'Mã OTP để đăng nhập là: <?php echo $otp; ?>',IDAC:1, noname:1}),
						success: function(){},
						error: function (xhr, ajaxOptions, thrownError) {
						}
					});
				});
			</script>

		<?php   } else {
			$json = file_get_contents('ds-data.txt');
			$json = explode("||", $json);
			?> 
			<div class="ds32 " style="padding:30px">
				<h2 class="ds33 " >Danh sách đăng ký</h2>

				<?php
				if(empty($json[0])){
					echo '<p class="ds34 " >Chưa có ai đăng kí</p>';
				}else{
					$i=1;

					echo '<table id="example" class="ds35 table table-striped table-bordered">';
					echo '<thead class="ds36 " >';
					echo '<tr class="ds37 " >';
					echo '<th class="ds38 " >STT</th>';
					echo '<th class="ds39 " >Địa chỉ IP</th>';
					echo '<th class="ds40 " >Thời gian</th>';
					echo '<th class="ds41 " >Thiết bị</th>';
					echo '<th class="ds42 " >Nguồn UTM</th>';
					echo '<th class="ds43 " >Trang đang xem</th>';
					echo '<th class="ds44 " >Name</th>';
					echo '<th class="ds45 " >Phone</th>';
					echo '<th class="ds46 " >CCCD</th>';
					echo '<th class="ds47 " >Address</th>';
					echo '<th class="ds48 " >Giải thưởng</th>';
					echo '</tr>';
					echo '</thead>';
					echo '<tbody class="ds49 " >';

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
							echo '<tr class="ds50 " >';
							echo '<td class="ds51 " >'.htmlspecialchars($i++).'</td>';
							echo '<td class="ds52 " >'.htmlspecialchars($j['ip']).'</td>';
							echo '<td class="ds53 " >'.htmlspecialchars($j['time']).'</td>';
							echo '<td class="ds54 " >'.htmlspecialchars($j['device']).'</td>';
							echo '<td class="ds55 " >'.htmlspecialchars($j['utm']).'</td>';
							echo '<td class="ds56 " ><a class="ds57 "  href="'.htmlspecialchars($j['currenturl']).'" style="font-size: 10px;word-break: break-all;max-width: 200px;overflow: hidden;display: block;">'.htmlspecialchars($j['currenturl']).'</a></td>';
							echo '<td class="ds58 " >'.htmlspecialchars($j['name']).'</td>';
							echo '<td class="ds59 " >'.htmlspecialchars($j['phone']).'</td>';
							echo '<td class="ds60 " >'.htmlspecialchars($j['cccd']).'</td>';
							echo '<td class="ds61 " >'.htmlspecialchars($j['address']).'</td>';
							if(isset($giaithuong[$j['giaithuong']])){
								echo '<td class="ds62 " >'.htmlspecialchars($giaithuong[$j['giaithuong']]).'</td>';
							}else{
								echo '<td class="ds63 " ></td>';
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
