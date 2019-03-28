<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form>
    <input type="text" name="goods_name">
    <button>搜索</button>
</form>
<table border="1">
    <tr>
        <td>新闻标题</td>
        <td>新闻阅读量</td>
        <td>发布时间</td>
    </tr>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->goods_name}}</td>
        <td>{{$v->goods_score}}</td>
        <td>{{date('Y-m-d h:i:s',$v->create_time)}}</td>
    </tr>
   @endforeach
</table>
{{ $data->appends($search)->links()}}
</body>
</html>