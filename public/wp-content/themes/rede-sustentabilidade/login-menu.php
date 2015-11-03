<?php
if (is_user_logged_in()) {
    global $current_user; get_currentuserinfo();
    $ApiRede = ApiRede::getInstance();
    $filiado = $ApiRede->filiadoFormWasFilled($current_user->ID);
?>
<script>API_USER_STATUS = '';</script>
<script>WP_USER_ROLE = '<?php echo get_current_user_role(); ?>';</script>
<?php if (get_current_user_role() == 'Subscriber') { ?>
<div class="filie">
  <a href="<?php echo site_url(); ?>/entenda-a-filiacao/" class="label">filie-se</a>
</div>
<?php } else {?>
    <div class="filie">
      <a href="<?php echo site_url(); ?>/entenda-abono-e-impugnacao/" class="label">ajuda</a>
    </div>
<?php } ?>
<div class="fazer-conexao">
  <a class="welcome-message label"><?php echo count($filiado) != 0 ? $filiado->fullname : $current_user->display_name; ?></a>
  <div class="dropdown">
    <!--<div class="seta"></div>-->
    <div class="item">
      <i class="icon-user 2x"></i>
      <p>Meu perfil</p>
      <a href="<?php echo site_url(); ?>/meu-perfil/">editar</a>
    </div>

<?php
  if ((get_current_user_role() == 'Editor regional') || (get_current_user_role() == 'Administrator')) {
?>
    <script>var WP_USER_STATE = '<?php echo getStateFromUserId(get_current_user_id()); ?>';</script>
    <div class="item">
      <p><a class="link-master" href="/listas/#/confirmacao/1/50/nome/asc">Pré-filiados à confirmar</a></p>
    </div>
<?php
  }
  if (get_current_user_role() == 'Subscriber' || get_current_user_role() == 'Filiado') {
    if (count($filiado) != 0) {
        $status = $filiado->status;
    } else {
        $status = false;
    }
?>
      <?php if ($status) { ?>
        <script>API_USER_STATUS = '<?php echo $status ?>';</script>
        <?php if ($status == 1) { ?>
            <div class="item">
              <i class="icon-tipo-perfil"></i>
              <p>Status: Pré-filiado</p>
              <a href="<?php echo site_url(); ?>/entenda-a-filiacao/">entenda</a>
            </div>
            <div class="item">
              <p><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
            </div>
        <?php } elseif ($status == 2) { ?>
            <div class="item">
              <i class="icon-tipo-perfil"></i>
              <p>Status: Abonado</p>
              <a href="<?php echo site_url(); ?>/entenda-a-filiacao/">entenda</a>
            </div>
            <div class="item">
              <p><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
            </div>
        <?php } elseif ($status == 3) { ?>
            <div class="item">
              <i class="icon-tipo-perfil"></i>
              <p>Status: Filiado</p>
            <a href="<?php echo site_url(); ?>/entenda-abono-e-impugnacao/">ajuda</a>
            </div>
            <div class="item">
              <i class="icon-download"></i>
              <p>Arquivos úteis aos filiados</p>
                <a href="/arquivos-uteis/">baixar</a>
            </div>
            <div class="item">
              <p><a class="link-master" href="/listas/#/abonos/1/50/nome/asc">Pré-filiados aguardando abono</a></p>
            </div>
            <div class="item">
              <p><a class="link-master" href="/listas/#/impugnacoes/1/50/nome/asc">Pré-filiados em fase de avaliação</a></p>
            </div>
            <div class="item">
              <p><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
            </div>
        <?php } ?>
      <?php } else { ?>
          <div class="item">
            <i class="icon-tipo-perfil"></i>
            <p>Status: Apoiador</p>
            <a href="<?php echo site_url(); ?>/entenda-a-filiacao/">filie-se</a>
          </div>
      <?php } ?>
    <?php } ?>
    <?php if (get_current_user_role() == 'Administrator') { ?>
        <div class="item">
          <i class="icon-tipo-perfil"></i>
          <p>Status: Super Admin</p>
        </div>
            <div class="item">
              <i class="icon-download"></i>
              <p>Arquivos úteis aos filiados</p>
                <a href="/arquivos-uteis/">baixar</a>
            </div>
        <div class="item">
          <p><a class="link-master" href="/listas/#/abonos/1/50/nome/asc">Pré-filiados aguardando abono</a></p>
        </div>
        <div class="item">
          <p><a class="link-master" href="/listas/#/impugnacoes/1/50/nome/asc">Pré-filiados em fase de avaliação</a></p>
        </div>
        <div class="item">
          <p><a class="link-master" href="/listas/#/filiados/1/50/nome/asc">Filiados</a></p>
        </div>
        <div class="item">
          <p><a class="link-master" href="/listas/#/admin/1/50/nome/asc">Filiados para admin</a></p>
        </div>
        <?php } ?>
        <div class="item">
          <a href="<?php echo wp_logout_url(); ?>">sair</a>
        </div>
      </div>
    </div>
<?php } else { ?>
    <script>API_USER_STATUS = '';</script>
    <script>WP_USER_ROLE = '';</script>
    <div class="filie">
      <a href="<?php echo site_url(); ?>/entenda-a-filiacao/" class="label">filie-se</a>
    </div>
    <div class="fazer-conexao">
      <a href="<?php echo wp_registration_url('/'); ?>" class="label borderd">registre-se</a>
      <a href="<?php echo wp_login_url('/'); ?>" class="label"><strong>login</strong></a>
    </div>
<?php } ?>
