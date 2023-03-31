
<style>
    .container_parent {
        display: flex;
        width: 100%;
    }
    .container_child {
        width:100%;
        height: 100px;
        margin: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffff;"
    }
</style>
<div class="modal fade" id="afterSellCompleteModal"  aria-modal="true" style="overflow-y: auto;">
   
    <div class="modal-dialog modal-xl" style="pointer-events: all;background-color:#ffff;border: 1px solid #d9d6d6">
        
        <div class="modal-body">
            
            <div style="margin-top:20%;margin-bottom:20%;margin-right:30%;margin-left:30%;">
                <div class="container_parent">
                    <div class="container_child" style="background-color:#4c4cad;">
                        <a href="{{route('admin.sell.regular.sell.index')}}" style="font-size:20px;font-weight:bold;cursor: pointer;color:#ffff;"><i class="fa fa-shopping-cart" aria-hidden="true"></i></i> Sell List</strong>
                    </div>
                    <div class="container_child" style="background-color:#1b1b4e;">
                        <a href="{{route('home')}}" style="font-size:20px;font-weight:bold;cursor: pointer;color:#ffff;"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a>
                    </div>
                </div>
                <div class="container_parent">
                    <div class="container_child" style="background-color:#337e33;">
                        <a class="normalPriceFromSellList"  target="_blank" style="font-size:20px;font-weight:bold;cursor: pointer;color:#ffff;"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
                    </div>
                    <div class="container_child" style="background-color: #f35a5a;">
                        <strong style="font-size:20px;font-weight:bold;cursor: pointer;" class="closeModal"><i class="fa fa-times" aria-hidden="true"></i> Close</strong>
                    </div>
                </div>
            </div>                        
            
        </div>
        <!--modal body-->
        <div class="modal-footer" ></div>
    </div>
</div>
