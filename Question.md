## Q

`@Title` 考虑如下脚本。运行时，尽管文件test.txt已经被用unlink()函数删除，脚本仍然输出1,1。

在脚本的最后添加什么函数才能解决这个问题？

```php
$f = fopen ("test.txt", "w");
fwrite ($f, "test");
fclose ($f);
echo (int) file_exists("test.txt") . ', ';
unlink ("c:\\test.txt");
echo (int) file_exists ("test.txt");
?>
```

`@A`clearstatcache()

`@B`fflush()

`@C`ob_flush()

`@D`touch()

`@answer`A

`@parse`PHP会缓存某些文件系统函数的返回值——包括file_exists()，这样能提高脚本处理重复操作时的效率。当脚本里有大量删除文件的操作时，缓存很容易就会过时，因此需要清理缓存。



## Q

`@Title` 以下哪个选项能将文件指针移到开头？

`@A`reset()

`@B`fseek(-1)

`@C`fseek(0, SEEK_END)

`@D`fseek(0, SEEK_SET)

`@answer`D

`@parse`fseek()用来移动文件指针。SEEK_SET指出偏移量从文件开头开始计算。

如果没有特别指出，SEEK_SET就是fseek()的默认模式。注意，rewind函数等效于seek(0,SEEK_SET)。