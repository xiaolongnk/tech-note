sql 这块有短板。 left join right join  inner join . is null, is not null.

```
select a.group_name, a.group_id, b.dimension_id from t_pandora_account_group a left join t_pandora_dimension_shop b on  a.shop_id = b.shop_id where b.dimension_id is null;
```


