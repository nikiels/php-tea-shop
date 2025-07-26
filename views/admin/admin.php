<?php if (isset($_SESSION['logged_admin'])) : ?>

<div class="container my-5">
    <div class="row">
        <!-- Левая колонка - меню -->
        <div class="col-md-3">
            <?php include 'partials/_sidebar.php';  ?>
        </div>
        
        <!-- Правая колонка - контент -->
        <div class="col-md-9">
            <h2 class="font-weight-bold mb-4">Управление товарами</h2>

            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Название</th>
                                <th>Изображение</th>
                                <th>Цена</th>
                                <th>Категория</th>
                                <th class="text-center">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produ as $p) : ?>
                                <tr>
                                    <td class="align-middle"><?= htmlspecialchars($p->title) ?></td>
                                    <td><img src="img/tea/<?= htmlspecialchars($p->image) ?>" alt="" style="width: 50px;"></td>
                                    <td class="align-middle"><?= htmlspecialchars($p->price) ?> ₽</td>
                                    <td class="align-middle"><?= htmlspecialchars($p->cat) ?></td>
                                    <td class="text-center align-middle">
                                        
                                        <a href="index.php?view=get_deleted_products&id=<?= $p->id ?>" class="text-danger" onclick="return confirm('Вы уверены, что хотите удалить этот товар?');" title="Удалить">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 

else: 
    include 'partials/_access_denied.php'; 
endif; 
?>