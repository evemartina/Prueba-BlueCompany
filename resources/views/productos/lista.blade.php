<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" type=text/css href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
        <script src="https://use.fontawesome.com/d60083496b.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-light bg-light">
          <a class="navbar-brand" href="#">Productos</a>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-3 offset-9 mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      Crear Producto
                    </button>
                </div>

                <div class="col-12">
                    <table class="table table-striped table-bordered dataTables" id="table_productos">
                        <thead class="thead-light">
                            <th>Producto</th>
                            <th>valor</th>
                            <th>fecha expiracion</th>
                            <th>categoria</th>
                            <th>acciones</th>
                        </thead>
                        <tbody>
                        @foreach ($productos as $producto)

                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->valor }}</td>
                            <td>{{ $producto->fecha_expiracion }}</td>
                            <td>
                                @foreach ($producto->categorias as $cat)
                                {{$cat->nombre}}
                                @endforeach
                            </td>
                            <td>
                                <a hrf="#" data-id="{{$producto->id}}" class="eliminar">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="nuevo_producto">

                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre"  placeholder=" ingrese nombre producto">
                            </div>

                            <div class="form-group">
                                <label for="valor">valor</label>
                                <input type="text" class="form-control" id="valor"  placeholder=" ingrese valor producto">
                            </div>

                            <div class="form-group" >
                                <label for="categoria">Categoria</label>
                                <select class="js-example-basic-multiple form-control" id="categoria" style="width: 100%" name="categoria[]" multiple="multiple" required>
                                    @foreach ($categoria as $cat)
                                        <option value="{{$cat->id}}">{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" style="display: none" id="div_fecha">
                                <label for="valor">Fecha Expiracion</label>
                                <input type="date" class="form-control" id="fecha_expiracion"  placeholder=" ingrese Fecha_expiracion producto">
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="guardar">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>


<script>
    var is_alimento=false;
    $(document).ready(function(){
        $("#table_productos").DataTable()
        $('.js-example-basic-multiple').select2();

    });

    $("#guardar").on('click',function(){
        let nombre    = $("#nombre");
        let valor     = $("#valor")
        let fecha     = $("#fecha_expiracion")
        let categoria = $("#categoria option:selected");
        let cat=[];
        let valid=[];
        categoria.each(function(i,v){
          cat.push(v.value)
        });

        if(validar(nombre,valor,fecha,cat)){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url :"guardar",
                    type:'POST',
                    data:{
                        nombre          : nombre.val(),
                        valor           : valor.val(),
                        fecha_expiracion: fecha.val(),
                        categoria       : cat
                    },
                    success:function(res){
                        console.log(res.status)
                        let row='';
                        if(res.status){
                            row+="<tr>";
                            row+="<td>"+nombre.val()+"</td>";
                            row+="<td>"+valor.val()+"</td>";
                            row+="<td>"+fecha.val()+"</td>";
                            row+="<td>"+categoria.text()+"</td>";
                            row+='<td><a hrf="#"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';

                            $("#table_productos tbody").find('td.dataTables_empty').parent('tr').remove()

                            $("#table_productos tbody").append(row);
                            $("#nuevo_producto input , select").each(function(){
                                $(this).val('');
                                $(this).removeClass('is-invalid')
                                $(this).removeClass('is-valid')
                            })
                            $("#categoria").val("");
                            $("#categoria").trigger("change");
                            $("#exampleModal").modal('hide');
                        }
                    }
                });
        }

    });

    $("#categoria").on('change',function(){
        console.log($("#categoria option:selected").text())
        let opciones=$("#categoria option:selected").text();
        if(opciones.includes('alimentos')){
            $("#div_fecha").show();
            is_alimento=true;
        }else{
            $("#div_fecha").hide();
            is_alimento=false;
        }
    })
    function validar(nombre,valor,fecha,categoria){
        let i=0;
        if(nombre .val()==''){
            nombre.addClass('is-invalid')
            i++;
        }else{
            nombre.removeClass('is-invalid')
            nombre.addClass('is-valid')
        }

        if(valor .val()==''){
            valor.addClass('is-invalid')
             i++;
        }else{
            valor.removeClass('is-invalid')
            valor.addClass('is-valid')
        }

        if(is_alimento){
            console.log()

            if(fecha.val() ==''){
                 i++;
                 console.log('aqui')
                fecha.addClass('is-invalid')
            }else{
                fecha.removeClass('is-invalid')
                fecha.addClass('is-valid')
            }
        }

        if(categoria .length < 1 ){
            $("#categoria").addClass('is-invalid')
             i++;
        }else{
            $("#categoria").removeClass('is-invalid')
            $("#categoria").addClass('is-valid')
        }
        console.log(i)
        if(i == 0){
            return  true;
        }else{
            return false;
        }
    }
    $(".eliminar").on('click',function(){
        let id=$(this).data('id');
        let tr=$(this).parents('tr');
        if(confirm('Esta seguro de eliminar este producto')){
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
            $.ajax({
                url :"eliminar",
                type:'POST',
                data:{id:id},
                success:function(res){
                    if(res.status){
                        tr.remove();
                    }

                }
            })

        }
    })

</script>