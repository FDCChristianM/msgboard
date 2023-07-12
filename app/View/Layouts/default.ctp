<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());
$assets = strtolower($this->fetch('title'));
App::uses('Router', 'Routing');

$controller = $this->request->params['controller'];
$action = $this->request->params['action'];
$isLoginPage = $controller === 'pages' && $action  === 'display';
$isRegisterPage = $controller === 'users' && $action  === 'register';
$isThankyouPage = $controller === 'users' && $action  === 'thankyou';

$baseUrl = Router::url('/', true); // Get the base URL

$userId = $this->Session->read('user'); //is stored in the session
$userModel = ClassRegistry::init('Users');

$user = $userModel->findByUserId($userId);
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Message Board - <?php echo $this->fetch('title'); ?></title>
	<?php
		echo $this->Html->meta('icon');

		// echo $this->Html->css('cake.generic');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('jquery-ui.theme.min');
		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('my-css');
		if($controller == 'messages' && $action == 'newMessage'){
			echo $this->Html->css('select2.min');
		}

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<?php if (!$isLoginPage && !$isRegisterPage && !$isThankyouPage): ?>
		<div id="header">
			<div class="container-lg px-4 mt-4">
				<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
					<div class="container-fluid">
						<a class="navbar-brand" href="<?= $baseUrl.'users/myProfile'; ?>">MESSAGE BOARD</a>
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarNav">
							<ul class="navbar-nav me-auto">
								<li class="nav-item">
									<a class="nav-link <?php if ($controller == 'users') echo 'active'; ?>" href="<?= $baseUrl.'users/myProfile'; ?>">PROFILE</a>
								</li>
								<li class="nav-item">
									<a class="nav-link <?php if ($controller == 'messages') echo 'active'; ?>" href="<?= $baseUrl.'messages/listMessage'; ?>">MESSAGES</a>
								</li>
							</ul>
							<ul class="navbar-nav ms-auto">
								<li class="nav-item">
									<a class="nav-link" href="<?= $baseUrl.'users/account'; ?>"><?= strtoupper($user['Users']['name']); ?></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="<?= $baseUrl.'users/logout'; ?>">LOGOUT</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
		<?php endif; ?>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<script>
				const base_url = '<?= $baseUrl; ?>'
			</script>
			<?php 
			echo $this->Html->script('jquery-3.7.0.min');
			echo $this->Html->script('jquery-ui.min');
			echo $this->Html->script('global');
			if($controller == 'messages' && $action == 'newMessage'){
				echo $this->Html->script('select2.min');
			} 
			echo $this->Html->script($assets);
			?>
		</div>
	</div>
</body>
</html>
