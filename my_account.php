    
<section class="py-2">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b>Đơn đặt hàng</b></h4>
                    <a href="?p=edit_account" class="btn btn btn-dark btn-flat"><div class="fa fa-user-cog mr-2"></div>Tài khoản</a>
                </div>
                    <hr class="border-warning">
                    <table class="table table-stripped text-dark">
                        <colgroup>
                            <col width="10%">
                            <col width="25%">
                            <col width="25%">
                            <col width="20%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thời gian đặt hàng</th>
                                <th>Thông tin</th>
                                <th>Thành tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1;
                                $qry = $conn->query("SELECT o.*,concat(c.firstname,' ',c.lastname) as client from `orders` o inner join clients c on c.id = o.client_id where o.client_id = '".$_settings->userdata('id')."' order by unix_timestamp(o.date_created) desc ");
                                while($row = $qry->fetch_assoc()):
                            ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                                    <td><a href="javascript:void(0)" class="view_order badge badge-primary text-decoration-none" data-id="<?php echo $row['id'] ?>"> Xem chi tiết </a></td>
                                    <td><?php echo number_format($row['amount']) ?> </td>
                                    <td class="text-center">
                                            <?php if($row['status'] == 0): ?>
                                                <span class="badge badge-light text-dark">Chờ xử lý</span>
                                            <?php elseif($row['status'] == 1): ?>
                                                <span class="badge badge-primary">Đã đóng gói</span>
                                            <?php elseif($row['status'] == 2): ?>
                                                <span class="badge badge-warning">Đang vận chuyển</span>
                                            <?php elseif($row['status'] == 3): ?>
                                                <span class="badge badge-success">Đã giao hàng</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Đã hủy</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('.view_order').click(function(){
            uni_modal("Order Details","./admin/orders/view_order.php?view=user&id="+$(this).attr('data-id'),'large')
        })
        $('table').dataTable();

    })
</script>