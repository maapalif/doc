

<script type="text/javascript">
    $(document).ready(function(){
  
        //setting to hidden field
        //fill data to tree  with AJAX call
        $('#tree-container').on('changed.jstree', function (e, data) {
            var i, j, r = [];
            // var state = false;
            for(i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).id);
                $('.divtree').empty();
                var id   = data.selected[i];
                $.ajax({
                    type    : "POST",
                    data    : {id:id},
                    url     : "<?php echo site_url('tree/getView')?>" ,  
                    success : function(msg){
                        $(".divtree").html(msg);
                    }
                });
            }
            $('#txttuser').val(r.join(','));

            })
        .jstree({
            'plugins': ["themes","html_data","ui"],
            'core' : {
                "multiple" : true,
                'data' : {
                    "url" : "<?php echo site_url('tree/getChildren')?>",
                    "dataType" : "json" // needed only if you do not supply JSON headers
                }
            },
            'checkbox': {
                three_state: false,
                cascade: 'up'
            },
        })
    });


</script>

<input type="hidden" name="node" id="node" value="" />
<div class="row">
            
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">                        
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-folder-open-o"></i> Navigation Pane</h3>
            </div>
                
            <div class="card-body">
                <div class="form-group">
                    <div id="tree-container"> </div>
                </div>
            </div>
                
        </div>                                                      
    </div><!-- end card-->

    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 divtree">                        

    </div><!-- end card-->


</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable( {
        });
    });
</script>


