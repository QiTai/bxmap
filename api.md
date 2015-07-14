API
====

API 地址：`TODO`

测试阶段后端请记着开 CORS

## 格式约定

后端 API 统一返回 JSON 数据，格式约定如下：

```
{
    "code": 0, // 状态码. 正常返回 0，发生错误时返回自定义的错误代码
    "msg": "", // 发生错误时返回错误信息. 可选
    data: {} // 返回数据. 可选
}
```

## API 列表

### `api/pv`

#### GET

query:

- time: number. 可选. 请求当天某个小时的数据. 为空时返回当天所有数据.

return:

```
[
    {
        "name": "", // string. 省名称
        "value": 0 // number. 该省流量
    }
]
```
