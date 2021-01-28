<?php
$start = microtime(true);
$root_url = 'C:\MAMP\htdocs\thydrive\\';

require $root_url.'\important\php\req_functions.php';

use Google\Cloud\Storage\StorageClient;

@ob_start('ob_gzhandler');

clearstatcache();

if (isset($_GET['icon']))
{
    $e=$_GET['icon'];
    //$I['php'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABhklEQVRIie3UvU8UQRjH8c9xGEyUYIRoYSRILAxooQkFYOn9GYbOkg5RQ2KHeA2FrdWVJBZ6nfKifwABjCEWNnqFUZAGjTHhgGKfDRvDLRtKwi+Z7MzOzPd5mWeGU514lQquu4yLOB/j39jCj+MaHsQTvA/QXov2K9Y8xkAR8CgWWsA2MYedHIPzGDkMXEIVzZzNNVzJmU9bEzPBVA4DVUw4OJM6PmBZku8+vMR3nEED17AUES9HuvrRhrs4i/ly5K4WE6kq+IO/eBiev0ZPeDiFc5jF1/D8aTicpmgYc+24l4mE5FAbAbyNFXzBGt6E8To6sB79ShhqZDhlVLJep/oY3xrG8Bk38Q9D+Ilv6Ip/r/Ag0jX2P6wN7yLsVKvoxdWIbh238AIXAjqDXXTjuqT6PuFOhrMTbPDcQRU8wrijq6WK+znzz7KRlMKrvDIt2pqY1uKVGImwjgPexVtJ9RypgUjVouQGt4JuSu7BJG4cBir62F2SPHadMd6WXKyNgvtPdZK1D4KqpZYBjwNWAAAAAElFTkSuQmCC';
    //$I['cpp'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAA0klEQVRIie3VMWpCQRAG4C+JLxJQJGCVG9hYBWIl5BS5QzxMcgg7TyIhXdDCIBh7K6ukSIq3moc81sJVLN4Pww4zu//PLDs7HBkXBT9DIxHvGj/FQIYlfhPZV+Dcop2QfGNtuDz4MvagEjhvgW884UH+KpILDHGFsf+GHOzsecVnTKAWyU1xH/w53jHBCJ2QfwviXTyWkcQquMNH8Ou4xXVYbwprC81YFZR38gp99Aqx5509L5iVnN12ckyg+ioqgTMR2CCTj7lUT3QROE839I+GP6IQcrLcQ0MQAAAAAElFTkSuQmCC';
    //$I['js'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABhUlEQVRIic3Uv0uVURgH8M/1J7YVIpZDtRWNQUSKa0vrhQZxEWoo58Zo61/Qf0B0tS2nEAdxEFcDDYLSaoorllx0eM/V4/ue99WrV/ALB57zPM95vs+Pc07NCfpxQ2ewh3955SoOO7RWW0G7IoIC4yWwnyLY6SDBcayrIthtCT0pZQITIYFPYf8i4fMMH6oIqipYxjc0w34p4XMvkn+2S5DCbSxG+6FIbruCFPrwuMR2XMG1GXIZ/uJrWKO4c1ashvTLvBvZG0Gu5c6uB99GrOzKObXTpkP0YiDsW0M+lX0ZQVM5ejGHDVm247JqBlNJ9jiNFvsKJvE8rIMcwcsgb2IbN4O+QJDHrKz0LyX2Bv7jNe5H+gdO5jUbHyhr0UO8x1N053wOMIOtYHuCN5G98ja+VbxBf7CAKdk3vB/kefxO+E9XEdQTB9pd9TjgZa5pGSpjjMj+kYtm/yPEOBOP8A6fZbemLGATa/iIMcWOnAu3ZH2dwXf8kg39FYYvErAKNcU/qBJHefKYEGLFiNoAAAAASUVORK5CYII=';
    //$I['java'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAC+UlEQVRIieWTS2icZRSGn/f755LLJGma6RhLiLeCQqWKkcDYmGRa6mUjFCxUxAvWxIKoC8HqTujCZiUo2NpWG3ChhBZF3Yg1mXTRRmMpUqQlCwlaQ9JpO4nOtMlM/u+4UCLWdDJFN+K7fs/znu+c88H/UoVM513Vet31wq2jIyqn/mr9keuCgwrNwVuYr7oxVQ3v6IgWm927mLb7ILzHX66diUbL6aLVHktls4V/FJDbuLGhNl7+GLEJ2Q7zLi3ZfSh4LHH0xOlKtVWNqC6+OGhiM/AyxgOSX+9RT+PRExdXql0x4Hxvb8J0eavgcN1s+HZxVVDE9Erj8NcrwqGKK1qTzRaBs2Z8q5Mny8DPyB6pBl5VgMCEPYV41EAm2wVk5nrT6/6VAID6r8bHDQ0UNnVmEl3jhxH5gMVrXs5VDS6jbUPBmqbULsQWwfsLkeDzub3353/Z3Nkib60K1HbbujdPlbzVRCi3YxowNHDhQM+nVQXc8MQX9WFN/BNBGigjLi0VGBFDOWETbtG9NH2oO5fsH31OxtbcgZ6HrmYte0UzHzxYBLaknj22wRQ+TBg/4iz083Hyc3u7Zlt3Zm+qmWd6crB7HsCZ9Xj4bjlW5R3Id4FexZW+8YEfii2Gw6m+0QthqDPFmHsDTKm+kZ0GUUVt97KIigFAsm/0cXxomCYsYoFCkpISuTaOrJ1qiHn3a2p6X2byWvV/H9HrI5HkFE8Lt957PpPZ8ziXBsoyRf9487nkOdzUwXs/BCZb+kfuuLg/c7aqF/y+MNuH7LXc/swegMYdx1fH3UJ76IJSrERu+lB3bsn/zPDtCtxH5bJlZgczsysGrH5hrDG4Mr8b8STikjxjJvsJXP5Pl28WtHl0t4wfJO1ZiLgzsZK/Ofdez6mKAUva9n3sxobzGxYDd6tkLWZqBMAomCOP/MSq2JXTc6X6djPbLriFiL2Yeyfzlw9YccnN/V82RcPgTgvcWrxSiFZhdYiEGRFQk7AfZTY0czAzVon139VvFgsovBtIv64AAAAASUVORK5CYII=';
    //$I['py'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAACFklEQVRIidWUPWhUQRSFv/PerhoLC4VFYhBMMKhVIghr4X/QbCABRSy0k6CVhYUJsTBYBAJaKVZWiqhYCJKAFpukCZjGykLQQhOFiEIkKia7ZudauJu3P2/fPrHK6ebec8+5M3dmYK1DsVhD2T2+Y69BCnkmmCuQnGT0wLf/NDBpcPKZoDckueCk44wefRWl4EV3PrFbkAHuAstV2c0yuxrdYCODgr8J+OISXAfmaoutuZFBohEBaPZW+BSDF4p4Qy4vGJh8Lln332KbWenuvYznXgIriGnwz+rgr/kSv2IH/kD2tEkjQBvgh1tYPe8ExmFwN4FzpWAwg6Fsu0mPgfb64pVwsIgsWdXASXsS1K8aeE59cYWLKHjoDp6lq+JNbNnQUloER2S2E4WO5DUwgZFbjcgWnMe4ZXrAvHs1x+azHZitMDApVStv96/tenBxuPVhH7AjMMDHMYTpFNjG2jL3tWYHKjqWYal12+dLw22PxjB1VQoQdf8KLOXflxbBkE1vq4hv3nWcb8Ho4t8wrp7gOFcNXPL3GAQJYfniS46Ln8BT3Lr+8mAw5JETHzWY7Td0A9gaKuHI6EjuRbRPrmIV+ZJtqildfKX1GDM6lN8fpRH92dXHFUwX4hCjPztn8+Et6Aye5TAtNjKI3IGOLc8Ct2oztg+jE3G7kUGs39Smkh3I70QuhekH4gPrc9NK8z1O/drGHy2tnxiFCSHrAAAAAElFTkSuQmCC';
    //$I['xml'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABGElEQVRIie3VQStEURjG8Z/J1sKUhTRlwZqtrJVPYWeUpZKFj6BsZKMUax9AUXYWNCmyUAo7oTtLGjEszlG32x2jO2Mz/Ot273nve57nvaf3nsM/bejLjCexhsGCenUs47xVwiE+OrwO0oKljEHRytOUvzPoOr1p8IAtoSPu4/MzdnEcc5IYv8WJ0By59OfEhrCDq2jyhiqWhCa4xjZWsIdT3GDmpwYlbGIaA7hMvXvFUSxguFXVWbE83tGM9zRVLGIcI0UNmlFkFVPC0nwxiwYWMnPOYmwjK5a3RE+YxxwesY8XrGMUdzGvIWwtFYzFWKXNB6npfKuopQV780f7VYN6FzST9CB74EwIB05ZMRLhwLkoOP8v8gld7VO021+EKwAAAABJRU5ErkJggg==';
    //$I['css'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABTklEQVRIid3Vuy5FQRSA4Y9oSNwSlVLjlkgUEqVWTeINeASPwJMoXBKdQhQaFGgoUDpEJyiQKCj2SObMObNtl0hYycoka2atf132zOa/yT1ev6l3ccDWBHD1A0nWxUgBtR8A1MX49QpSQAdaPtCOzwDSFvVVyLinLEZbGR1beM4E3sEiuhP7dRkgrWA0ExyOwtqb2C/LALkhb2IlsV2E9VMVPATtSuw1rGXgcQX3wT8LoKhiJLFNKvodyzaO1VdwnZxpCqhFgBPsox/LybmbJoCGi5p+ptTPYQ8LWGpy7jas8WfaMMNci97lfRZ7mMBc8FnFQdiLK6gEiMscwiDOcRg0lgGMZXyzgDiLcZzhFOvYwAtmMRP2c75ZGfH1f8FwFUDnNwCdVQAUvZ1XDPOhJOCj4j4sarw7KJ7bj6QdU5gO+qp4BLewi6eqWf9NeQM3qnblPzyi+gAAAABJRU5ErkJggg==';
    //$I['file'] = 'R0lGODlhEAAPAOYAAIyMlu7u9PHx9vDw9fT0+PPz97u7vvf3+vb2+d/f4vn5+/39/vv7/Pr6+/b29+3t7pCRnI6PmZOVn5ibpZWYopqeqJ2hq6KnsaClr9fZ3ff4+t/g4qSqtKmwuqeuuM3P0vHz9tze4be6vuzv8+vu8urt8eXo7Kuzva61vquyu9/k6uXp7uTo7cvU3dHZ4dDY4Nfe5d3j6dzi6Nvh5+Po7eLn7OHm69HV2ejs8Ofr7+7x9OHk597h5PT2+PP19/Hz9evt7+Lk5t3f4fr7/Pn6+/b3+PX299Tc49rh5+ru8fDz9ff5+vb4+fP19vz9/f////7+/vv7+/Pz8+/v7+zs7Orq6ubm5uHh4d7e3sDAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAFkALAAAAAAQAA8AAAevgFmCJ4SFhDuCiYIdUI1QDQ9NKCGKgh4LjQsOG0smKRmVHAxPUAtGQktLPxxTihcKjU5FQR8iBhdXihgHC05DTEA8NwkYWIoWCENEGj1KJCsIFsaJFQRMPT5KIzk2BBXTghMFIEo6JDk1MQUT4FkUAiVJOCs2MTACFO0SAyw0NiozYLgYIKEdhAAyZiCBceRFiwAQ2kUIQLFixQjtAGjcyBFAuyhSqFgZSXJklSyBAAA7';
    $I['dir'] ='iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABG0lEQVRIie2Tvy4EURTGf5fZmNiNiDXEn41Mglps5QVk230AhYKCxhug8Q6i8go8h1olGo2ILBHMuHPPVdhsJhI7d5JrGr76O+d38n058K8CKYC7c5q1gG0Foz8ahetoi4uygABAa3YzzUmR+faM43iHo9KAt3fGlJv/8P5ybTOciJ6Guqw1Sa93MNu9uvkCJP2sCjS/2mZmeX3D5ZJM2xrQCQDqzXghHG8MHWhMThG1YhDtsh8jJoR+RNNziytRa6l4ymZOywEQwwAAptywk/IAK/4BVvIAA+IbUGVEIoL1DBDJR1RJyd47+F6ydXsgd0ClfyC/8Af5khU69d2BEp0MAOlzsvdgH0/ViKr7WG7FvqYvH/s+dv0BfQLuI3d11aBYmwAAAABJRU5ErkJggg==';
    //$I['doc'] = $I['docx'] = $I['odf'] = $I['docm'] = $I['docm'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABCklEQVRIie3VPUoEQRAF4G9lE0VYDBTcIyi4K0aLgeBP4gVMPILHEPE8ewAzMfYMGplpIogwBtMrM0OPPe1otg+Kaaar+tWbrqphiQQGif0xDho2ziEYJg7bzjkshqqCIjMm5T+AldyMcjFMu7Si7f5qypoKbnEZ1hc4wyuuwl4vFLhWqnqpZHiPLdw0sisSFlUwxSfmFaeHQDj5CwVPYX2ONWXpHoV3z7pVWk1BrEw38YE9jHCHdaWKZkwbwbdfrEwneMMhZnjH/g+ZRr/9AjGCaXjOgi1If4VYH5zgMRy+ilMcR/w69UGfUdGG2h306eROCf37LKrK3cCu+rjeScRkEcTQ+4ezRBJfGu424dY1nP0AAAAASUVORK5CYII=';
    //$I['xls'] = $I['xlsx'] = $I['xlsm'] = $I['xlsb'] = $I['xltx'] = $I['xltm'] = $I['xlt'] = $I['pptx'] = $I['ppt'] = $I['pptm'] = 'R0lGODlhEAAQAPcAADVJGjRNGTVNGDRSFzRTFzRYFTReEzReFDVeGjNpDzNtDjRtDjRjETRkEjZjGztoHjpvHjNwDTlwHjp3GTx3Hz57HjJoKDtxIjp9Jz99IWB+XEKAJUaELEeFLUKJNUeIO02MNk+OOUiSP1OTQFKXSFiYR1qaSVieUl6YVV+hU1uiWHCbbWGiVGGgWGWnW2eqX2SoYGmtYmqsZW2wZ3SlcG6Ov3KQv3KRv3aTvXqVu3uVvH6XulWAyFmBxliCxV2ExF6ExGGIw2KJw2WKwmeLwWmMwWyOwP8A/4KavIWdvoephZC9i5ywm6Gzn4igwIuiwoyiwpGnxpesyZCu1p2xzaO20am71JPCjpPEjZbEkZrGlq/A2LPD2sDRwMzay8/dz9bi1t/p39Li+tTj+tbk+tfl+9nm+9vn+9zo+97p++Xs5eDq/OHs/OPt/OXu/Obv/Ojw/erx/evy/e3z/e/0/fD2/vL3/vT4/vX5/vf6/vn7/////xLtPAAAAJEFyCLVGBLuCJEFURQHSBLtWAAAAJEFyCLVGBLuJJEFURQHSJEFbRLuaAAABAAAAOaERAAAAgAABAAAMAAAAFeQiNSLsf3QAAAAMAAABBQAABLrmJD7bAAAIAAAACLVIBLuOAAAAAAAIADwqgAAIAAAAAAAAJDnvJDVhhLuCJD7bJD7cZDVhpDnvBQAABLt5JDnyBLujJDuGJD7eAH//wAABBLtaAAAABLujJDuGJEFcP///5EFbZEJvBQAAAAAACLVIBLuSJEJkiLVIAAAABLunN3tDt3tIGKmyAABwGKm1AAAAAAAAAAAAAAAAAAAABLuaBLu7BSuABSuABLuoOb8I8OlLsYaoBLu2MLCzQAABMLC4xSsQBSuAAAAAxSg2MXS4BSgABLu1BLupP///xLvQMNclMEgcP///8LC40SV1RSuAGMboGMboEUEtRQAABSsQKR+UAAAAAAAAOqG1OqG1OqG1OqG1AACBBLvJN1sdBLvLKR+UKR+UObgowAACeaCsAAABCH5BAEAAEcALAAAAAAQABAAAAjhAI8I5GKlChUpUZ4k2bFDoMMjW/TkwXPHTh06O/Y0PDIjhosUJkaA6LChwpyMGjnuWclyZQQ5KDXOuAKDxB4vKFAwURCHoc8XarDI8ECjxQcwCeC8cdOGzQ4We75oUYHBQpc9DJY2XbOjxJ4lJ7KouLAizAE3U6asSZMjxBIKEBwsEfGgSYGtadDg4NBSiQQEGgawSYvmjI0MLVsKWFvYjJEJERYkaGCgAIEAANKkNVOGiEMoWtkwPsOZjBCHTpimXZ2WzBggDpPgbVzGtZgeDpHo0IHjRo0iQ4L88MGDR0AAADs=';
    $I['jpg'] = $I['gif'] = $I['png'] = $I['jpeg'] = $I['bmp'] =  $I['gif'] = $I['tiff'] = $I['raw'] = $I['fig'] = $I['webp'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAxUlEQVRIie3UPa5BURTF8R8vkehV8magVIqe6LVGYRpmIKIyhzcAidIMxNXoiZICCdch17uHKKxkN/tkrf/52Dl89UnqYIV9zkrQDgGSCOHnWp5DCxeAfY7Th1SAYuTQG2UFNNB8JaDo+joz62PfYIM+ts+Y7o3cOtDrnjy9B75MgD/8YHLRG6R8o/8CFqic1sqYYYpSylfG/FnADvXU+i+qISNqju+SGTC+E/RIwxDgrWO6ihiehJptcX7UJVoRN/tVTh0Aqfp7GiIoV50AAAAASUVORK5CYII=';
    $I['txt'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAA7klEQVRIid2UsQrCMBCGP0UEcfA5HHwEpy4quPoqdXTU9/ANXF3FDm4+gFB3V8WlDibQxqS9NhHEH45crpf/z3GXwj9iBlyBTGCrJgJScpFIyxLL1DqvuMgW6AFdYAMsbUntCpIyDIA78ARiYB1aQCTiK6BFHsqPzY8dD2KzR7uqA3XGs8ycCEH+IZAf08wRi4AFcAIuwN5xzsZZgHkL7R+BIdBXvi2nVgU6nt+P1HouybFWIBnTBLgpSwT5TjVXBREwVvsD7x6YOS7OAr4yRXlMgTS0gM/f1IR+ybWbHBw+vUglAk17kQIT//p+DS9V76mKcQRQQgAAAABJRU5ErkJggg==';
    //$I['avi'] = $I['mpg'] = $I['mpeg'] = $I['mp3'] = 'R0lGODlhEAAQAPcAAEhHSHd2d//+/+/q9+7r9KalqPLx9NrZ3HZ1e4mJjx0dHoeHi+Dg4/n5++np6+jo6tLS1NjY2ZqamxYelholkUBHhIWGjHB2lREwshozpCdDujZPuoOEiIWNqBI7tJWWmdTV2B1NwihTuC9iyDZqzlF60X+Vw/z9/xtbyxZczvb5/h1m0EqA0EZ/z1aP3srd9h502hh24VSc6SuD3oqLjNfY2SGN70ik6cHe9ODn6urv8MTGxnG+AYTVDXiuKaPOX6DEZ+nu4XO3AWWgAU56AYypWoWWaNPcw22pAWacAVyKCTpTCm2bFF+BHHehLEVnAWGNBk9zBXWDV1BhKsbKvZm0VajRMHKKKJG5AUlaBnp9b4ulGoqMgYiIhoKCgLOzseDg325qVf/++dqvAdmvAei7As2oBtCoB8qlB+jAF+jAG6eLE5yDGezHK+fFN4RyIN7AOOTEOuPDO4BuIu3MQ+XIR+rLSuXHSOXHSu3VaO3Wc+7YeIuFa/ry0vz343lxVn16cnh2cMHAvpOOiPjx6evq6eHc2v9zTfV6WfnRxuHLxfvx7v9KG/lHG/hIG/lOIvxNI/dOJP5ZLv5aMexYMvVeOPRjPv9xTP92U/BzU/99Xet2WPKijvWvnu+unvGxofnMwNvLx/r19P////v7+/Ly8uzs7Ojo6Obm5uTk5OLi4uDg4N/f39jY2NbW1tLS0s/Pz87Ozs3NzczMzMfHx7Ozs62traenp56enpycnJqamnl5eWtra2RkZE5OTiEhIRwcHBsbGxMTEwgICAQEBP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAMUALAAAAAAQABAAAAj/AIsJXMRpE6UtPopQMSCwYTFQlRpBeoSFxxAlRg44TBRpEiZNiKz0EJKEiBQIAkVZkoTpU6gINY78QALlCRdVxTw5utSJEK8dDggMAMIkypQCpDIxOqSIEABeu2gJCOKkyRIvq5QeMuTU169hvR5UuZJFC6wWM27kcBqMGDBYDPLAMcNnFosYNnAQUiDsFqwTfuy4OQNolokUMGToGCSowahRe+6oWWMhFggRKFa4eKFCTB89deSM+SOBVbEOHkKMIFGCDh08ccq8+WBLYKELGTBo2NCmTRoyczjkStUQTIIKFCagQcMmDA1crRwWK/WlC4JAARboqnVKekNTrmTJBnqFapTDgAA7';
    $I['pdf'] = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QA/wD/AP+gvaeTAAABMElEQVQ4ja2QP2vCUBTFT1qb14YiDQE1LXVxEQKlS/MFnou+L6Dg4OwqOPtFnCWbILq4CglZqoulc6m2tSktXZKASZdWavNPpGd6HO773XMPh2/plPqI0QEhd+popHBA+JxOqR8lnVJ/Wqt5JmO3AXDc1t9S2m2OF8Vrk7HpXoCUIEBptcCL4pVZqZgbf1eA0Wz+PDkAN4GBvx1467V/3+n4H7NZaCeJJ3i2jbfJBO+GEZssEnAoCCDZLE7y+f0ArmXBXa3wOZ/HAiJLfBkOQXI5vI7H8GwbqXQamXIZQqEQn8BzHDx0u1hoGo5lGefVKlzLwlO/j+fBIDnBQtPw2Ovhol7HZaOx8Z3lEkeSlAzIMIbTYhFnqrrlE1kOPTUA4CUJfMimKG0BjFJp54//pi+Q65EcoQuJqwAAAABJRU5ErkJggg==';
    $I['rar'] = $I['zip'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAB6ElEQVRIie2TT2sTURTFf29mqmMTYzGm1tpiI2nAnVgo6AcQoSvBrYILXagLV25VED+CIK5KqeBWl/7BLyCuxI2iQkMjaRJtiE3y5t3noulkwtimGbvTs3vvnnvPO+fy4D8GQAGsLJId8biqwN2WKHzMXeb5sAIegNZcDzQPB5G/POF+/hr3hhb4tcF+tTv+3e8vTp/3M7kfWxfN9frBRm0tOzEz+zVkWWta9frtoxfffd4UaHWzGoDJ4hzjhTNnt86NWoXmegk/nSUzPnMqyg20HQEueACpbP64P5recXh67DC56TyI7j1UOojRuF6q7x7AiPGhG9GRY1OzuekTgy3YoO+osDiOwnQ6sRpiCAXAxAm7gBXdcxDrjwpYSSSglOA4Dka34/1WogIGJIEDE3QdjMb77R5ElBnL4Dp5quXVnSMSEWwCgaVXimdvU/j7CizeCUj5vZpINKKEDj6tOBijaG5AqWIoTm3jACuJdlBaczFm84uWq0JxUnrF2JKtjg0YhNWq4tEtzdM3LuWaDRcbzuQvIzo54bL8Gj58syzM6/DV4cxQQJL9gwdXAl6+91iYF+YKAjZSjC5ZodtJdnDoAFw61+2T/poS3QoF2j9bNyq2+lg5KjW0yh9gxTbbjc7NvZj1D+A3Gx7e8wMlBgoAAAAASUVORK5CYII=';
    //$I['html'] = $I['htm'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABSklEQVRIid3VPS8EURTG8Z+XRmQF8VJRqNhOotGJTqlRaiQ+gMa38CV0CgoJhUi20qn0IrskQsEqiIpibrKzNzNjho2Ek5zMvTfnnv957tvw36yNjx/6czphfwS47UGRXTliQKsHgK4cv64gBoyg7wsfrgKIl2iyRMXTRTkGi+iYwjXOsZgDGIj6d0WAPAXvGMsBxNYsAmQpgF3s5SRcw06qX6jgJfhIBLgKnmVLqXY7zM8FkKioh/am/LXfxzEmUmN3cVAWoJUCzAfPspPwTZ+iZhwUH1O696GBcWxkxD2Gb2UFacAoniRLsYrlUNRFcDr7FM/NtS2dl/EBswWxM7hPxW9VVTCJG1ziEEdhfD34kuS5qKSg7vv/goUygNoPALUyAJjDNg4kFycv4SvOJDe9npWoL2swsiGsSJ6EtTB2GryBt7JV/037BHTccvXiX3/pAAAAAElFTkSuQmCC';
    $I['mp4'] = $I['mp3'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABWklEQVRIidXVvUrcQRQF8J/ZDYQFFzQRRNAubCEScIsQtooi+AA+gYV5APt0FiFFnsBXEDGCCCJp0kRhJU1qWRA0IBpDCoMfxcy6Awns7PLfQA4MDIc7c7j3zNwLZRzhruB1hFIZw3GdYELABc7jfhyVuD/GDR5jMnJX+B73Y/EuGEVVgkai/i7hNxP+WeRqCbeexK4nfA0eGTBKeIJlvBKygJ9CWepYEMoEp5jBS7yO3C/BxzrmMRX5M3whpF20wQ8lHXiJcgV+4PcgBZYwjY/9iOR40Eji5/A140zfHuxjFm90PlihGaR4ip2iM+gJ/QqUsYJvWOwW2Cvm8UH40V2Rm0EFz7GFvdzL28gx+RLXGXF/mJxbomr3kL/jn7TrW7SEF9F+77t4j22h/bbb9So2cKDTrj9jLcaO6rTrt/iUiv2fE20IIzgUJluRQ7+FFwQfmoqfZk2U7gGVfLnzAT4L6AAAAABJRU5ErkJggg==';
    //$I['c'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABkUlEQVRIidXV30qUQRgG8J+rqYVEpgvC7hqddRRtBx4FSgddR3fRRXgT3omGJxEJEVFRZ2qRCCoqCh5kBzO7Td/O7H7umQ8MA+/7fs8z37x/htuOiRH+BtpxzeNetF/gGPtx/RlHoINnmBtxiHN8xF7OOVkQ7eI5pkeQizHLuIODOgJdPKlBXMVi5Ps9TKAjnHxcNHGC055hKnE2hDvP4QFe4ymu8B4b8snt4lfP10gcbfmETuINVjCL+3gZ9xzmItfAH7QHY4mnfoRLrAvlOSVcRQkt7FYFHhaCV+K+iW9DSFP0udIrulsIbsZ9vyY5/xryP4ESrm9APPBNKnBZCO41TylHOfS5UoGjQvC7uK8JDdjC4xECfa600SaElq/iUKikJazilVCmb5X/+rPYbKnAmVCOM5kPPmAhrgtsCc2Wy885dnq+6jTt4EXhVHWxLam46iw6Fabi4pjkX/AjNeSm6UG0NzO+YfiKT1VjToAwck+EjszlJMWZkI/vOWfdJ7MVxdIn80i465+GPJm3H38B8NFDyEIr4IkAAAAASUVORK5CYII=';
    //$I['h'] = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAOCAYAAAAmL5yKAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAHsSURBVDhPdVJNb9pAEH1eL0LNPciGHwAGKT3CLf0RNOcq9Nzco/yBRpB/wB9opObcNEioRFzJzZUimkYCNQduBCnGH9t9g2xVrTrSenbf7Lx541nHWMuyDIvFAicnH1CtVuE4QJYZKKVgw6A9PPxAvz9AEDTlTJxxpGlquKbTqRkM+uQz2+1WMC7uaUdHXdNsNsx4PC4wxi3JrkqaJraygziOobUWjMpKpZJgrutivV7j+Pgdrq4+C8b7mpdoTOI+9zQm5YSnp2e4ufkqscvLT6jX6zg4eA2dK4jjRHqysoSZ+yRJRAF9EARotVqyZ5xqmKf4Ibi39wrlclkSeSFPpoK/Mea4rhZcR9ELwvC7rZyh0+lgNptZmanIpiqtXZvAqaTY36+gVqtJezxLy8PhEOfnH4WVVWie52Gz2cgFehrjVHh/P5d7jqNEgbIjKZLpuXq99/Zv99BoBAXGeBRF0tLuJ3NyKexLQJGc78MwxPX1Fzw/rwssJ2FrrMwzp6Tb7TYOD99IT0qx3wyr1QqVSkUqeZ4vmKWB73uCSWVLQk8mY2WZ5XJp7u5mxSsjZv86n/k/2MXFwEwm3wRTZCTb4+NPjEaj/47uT4yVOUbmFg/J96u4vZ1gPp8Xfe/I2b9ABfb09Avd7lt7dvAbkjCSYBvjDUwAAAAASUVORK5CYII=';
    //$I['css'] = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAOCAYAAAAmL5yKAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGzSURBVDhPjVLPLwNBFP5mdrViu7tNSzjUAaEXERfpxYnEzd/g7g/gKL3wD7j4J5w4ikhcCBEiEofaaLCrfoRqm7A/xpvdtrTr4Nu82Tdv5nvzvTfDHMcSQgT4D1zXhaH3I6WnwzljDFySKcO/zPdc2PclOA838H0vjPEwVTdY8x9DtFCtvuLWukK9/t6ZQEpaPlZx9BTPu36pYqfSBzOTRTpDZRgGGo23zgSC7PWTodAf78liLsB1VWnOftBOIMnFcwUjKenFMZYKsOcA+4+d6tozWd3alA+rxv9sQYni80MCc4Od6rqKFcgmBY6e41J37zgmDLqN5rwFZtsluo24bNnQ33FGXzdd7mHbFxZFWwtS/I8fp0i0ChRRArZZJq8VExg3VYyZCg7tL2SSHJNZFfv3X8hT3EwyHNguGO0TUiFRqGPElh6ZJC/le3FSceFSr1anNTw1Avjkr5Bf/giaZ0UcJugph2QC+fBp6KG2ajQonGHjrI6F4QRmhxIontRQnNGgqdHJYQ4ypm/diZpHR8goqclpHKO6guOKR6XwkHD67KMwoODlkx7Tmx+yBRNIqRzfLbbCmsG46bwAAAAASUVORK5CYII=';
    //$I['rtf'] = $I['txt'];
    //$I['exe'] = 'iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAAB5UlEQVRIie2VOU8bQRiGn5k9MELIXLIscYmGIzQkSkCuQDINwjT8Nv4FBQ2Yio4CJQYsUdgFh5CMOFbCAmED9u5Mik0sQUBMkjWRIG81xzfv8803M7vw3iQeD2gQW+m0+hMz6brbU+vrn/8GHExkMr/MPSutyWeztCaTunZ5+W0ym516MUljcwN9WFoSblfXl69zc9uvCnbi8RDe3f3xJXik4N+BRw42hduR0bRma3b28agAPjUPLAQTmcyTyeTX1vRTS5pSahP9M7BRqWV/PyIWA0CVSsi+PtTJCcRiiPZ2tOche3sB0Dc3qNPTaMB2KoWIx9GVCur8HDuVIigWET09UK0SKIUzP4/yPNTxcXRggKBQwN/cDNvFInJoCNHRQX1lBVpaAKgtL0OtZuRnfMbW4CBOOg22TVAoIJNJqFRQFxeNGGd6GmtkJFqwvr9HX12FHSFACLR6+BPT19fo21sjP+NSq7Mz/FwOAGtsDHV0hBwYQCYSjRh/d7cJpR4exl1cRCYSWKOjBPv7qFIJa3y8EeMuLODMzBj5Ge3Yz+UQbW0A6Hodf2cHdXCA9jxEZye6XKa+sRHOV6vRgdXh4YN+UC6HkLs7+HG5gr09I+BPvb9P5n/w2wc/95xEfnX1VRN5+/oOGBe3FyxWzt8AAAAASUVORK5CYII=';
    //$I['text'] = $I['txt'];
    //$I['tex'] = $I['txt'];
    //$I['csv'] = 'iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABmJLR0QA/wD/AP+gvaeTAAABpElEQVRIidXWP2gUQRTH8U9ikKCNZSQXEEErO5sEYpPKf4VgJ1haWVqksrMTLQISwSa1MdiICmrjaWcn2mgggoUpgsYQBOVci5kle5PL7lw8Ij54LDP7m/nu771ldukdLSziO4qGXMGlHfapjRbWMgBpzvYLWowLH2G8QXsqgd3oB1SWq5WhHbXd2e1cULmgX301b+4VqMD1vQIVuDxIULsGtDJIUBoHcS5nn78F9dxneAAbZsUwXuuu6y90krnP+Kq+8e0mWClcxXnsj/kem5iOun1Yxlwcv8MHDOGe7eXuKt1I5cbV6O4ufuIonuAVbglNPoLTUf+isv5sk5uS3MEBXNNdjrfRyVjlqQscwwVcxMn06Xs5Kl+GjtCbVHwCz3EYV/Aszp+J7ttCubOiJM/gEO5gXijfx8oYFqL2aWX9mxxH1YllTAnNHcUnPLTlehIbUftD6Nk4fueC0iNkM7opx9/wJdH0ypdNoDT+/5Phn4E24jXnU75TTMTrep1oSajt413CJoQTpcCDOuFxu/vdSnNNOEFqo4X7gvV+AevRSRfkD4k25biMDCuLAAAAAElFTkSuQmCC';
    $I['file'] = 'iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAhElEQVRIie3UQQrCMBAF0Id4DvE42tt4gy69pAitW3uFdFOwCNppgiiSDyGBhHkDA+Ef06BHerMGnHKBpeIJ12lvc4Cl4gk7XKbz+ROAEiQKZCNrANh7zCQ0+LXAHLk/X2wj4osmQtlkAuFUoAIV+BJwK6jXRx4d0Yl9evPV4VDQ3I9mBMVQXpzXjsQOAAAAAElFTkSuQmCC';
    header('Cache-control: max-age=2592000');
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T',time()+2592000));
    header('Content-type: image/gif');
    //print base64_decode($I['file']); 
    //exit;
    print base64_decode(isset($I[$e])?$I[$e]:$I['file']);
    //print base64_decode($I['file']);
    exit;
}

/*if (valid_session() == 0)
{
  header('Location: ../');
  die();
}*/
$_SESSION['userdir'] = 'folder-2';
if (! isset($_SESSION['userdir']))
{
  unset($_SESSION['emailid']);
  unset($_SESSION['password']);
  header('Location: ../');
}

if (isset($_GET['id']))
{
  header('Content-Type: text/html');
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_URL, 'https://storage.googleapis.com/sruteesh-static-pages/404.html');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec($ch);
  if (curl_errno($ch)) 
  {
    echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);
  echo $result;
  die();
}
else
{
  $date='M-d-y';
  $files = $dirs = [];
  $dir = $_SESSION['userdir']."/";
  $files_list = $bucket->objects([
    'prefix' => $dir,
    'delimiter' => '/'
  ]);
  foreach ($files_list as $f)
  {
    $temp_files = [];
    $obj = $bucket->object($f->name());
    $info = $obj->info();
    if ($info['name'] == $dir) continue;
    $url = "file/".substr($info['id'],strrpos($info['id'],"/")+1,16);
    $temp_files['name'] = str_replace($dir,"",$f->name());  //name given
    $temp_files['url'] = $url;                              //url given
    $dt = new DateTime(substr($info['updated'],0,10));
    $temp_files['date'] = $dt->format('m-d-Y');             //date given
    $temp_files['size'] = $info['size'];                    //size given
    //print sprintf("<script type='javascript'>_f('%s','%s','%s','%s',%d);</script>\n",($temp_files['name']),$temp_files['size'],$temp_files['date'],($temp_files['url']),$temp_files['date']);
    //print sprintf("<script type='javascript'>console.log('I am Sruteesh')</script>");
    array_push($files,$temp_files);
  }
  //$dirs_list = $files_list->prefixes();
  foreach ($files_list->prefixes() as $d)
  {
    $temp_dirs = [];
    //$obj = $bucket->object($d);
    $info = $bucket->object($d)->info();
    $temp_dirs['name'] = str_replace($dir,"",$info['name']); //name given
    $temp_dirs['name'] = substr($temp_dirs['name'],0,strlen($temp_dirs['name'])-1);
    $id = substr($info['id'],strlen($info['id'])-16,16);
    $temp_dirs['url'] = "folder/".$id;      //url given
    //$date = substr($info['updated'],0,10);
    $dt = new DateTime(substr($info['updated'],0,10));
    $temp_dirs['date'] = $dt->format('m-d-Y');             //date given
    //print sprintf("<script type='javascript'>_d('%s','%s','%s');</script>\n",($temp_dirs['name']),$temp_dirs['date'],($temp_dirs['url']));
    array_push($dirs,$temp_dirs);
  }
}

$date='M-d-y';
$up_url = "";
$dir = "";
$end = microtime(true)-$start;
//echo $end;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Drive</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="view-source:https://assets.gitlab-static.net/assets/application-7403f60a856c785734d794f3f673e3d370cd97cd2fe308e29ca85f3e2ea2c653.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.6.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.6.1/sweetalert2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://s3.ap-south-1.amazonaws.com/cdn.sruteesh.icu/css/sementic/semantic.min.css">
    <link rel="stylesheet" href="https://s3.ap-south-1.amazonaws.com/cdn.sruteesh.icu/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <!--<link href="https://storage.googleapis.com/sruteesh-static-pages/index_main.css" rel='stylesheet'>-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Spectral+SC:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rufina:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:wght@300&family=Zilla+Slab:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <!--<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-4ZPLezkTZTsojWFhpdFembdzFudphhoOzIunR1wH6g1WQDzCAiPvDyitaK67mp0+" crossorigin="anonymous">-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/aes-min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <style type="text/css">
    .cont 
    {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 17px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
 }
 .cont-add 
    {
  display: block;
  position: relative;
  /*padding-left: 35px;*/
  margin-left: -9px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 17px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
 }
.swal_validation
{
  font-family: 'Rufina', serif;
}
.swal2-input::selection
{
  background : #2196F3;
  color: white;
}
.swal2-input::-moz-selection
{
  background: #2196F3;
  color: white;
}
.delete-swal
{
  font-family: 'Patua One', cursive;
}
.arrow
{
  border: solid black;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
  position: relative;
  top: -3px;
  margin-left: 6px;
}
.copyright,.addfiles-swal
{
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  font-weight: bold;
}
.down
{
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
}
.date
{
  display: none;
}
.up
{
  transform: rotate(-135deg);
  -webkit-transform: rotate(-135deg);
}
/* Hide the browser's default checkbox */
.cont input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}
.swal-checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 22px;
  width: 22px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.cont:hover input ~ .checkmark {
  background-color: #ccc;
}
.cont:hover input ~ .swal-checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.cont input:checked ~ .checkmark {
  background-color: #2196F3;
}
.cont input:checked ~ .swal-checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.swal-checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.cont input:checked ~ .checkmark:after {
  display: block;
}
.cont input:checked ~ .swal-checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.cont .checkmark:after {
  left: 11px;
  top: 7px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.cont .swal-checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
    a { cursor : pointer; }
    #idx { border: 3px solid #fff; margin-left: 2%; margin-right: 2%; font-size: 20px; min-width: 50px;}
    #idx td.center { text-align: center; }
    #idx td { border-bottom: 1px solid #f0f0f0; }
    #idx img { margin-bottom: -2px; }
    #idx table { color: #606060; width: 100%; margin-top:3px; }
    #idx span.link { color: #0066DF; cursor: pointer; }
    #idx .rounded { padding: 10px 7px 10px 10px; border-radius:6px; }
    #idx .gray { background-color:#fafafa;border-bottom: 1px solid #e5e5e5; }
    #idx p { padding: 0px; margin: 0px;line-height:1.4em;}
    #idx p.left { float:left;width:60%;padding:3px;color:#606060;}
    #idx p.right {float:right;width:35%;text-align:right;color:#707070;padding:3px;}
    #idx strong { font-family: 'Vollkorn', serif;; font-size: 1.2em; font-weight: bold; color: #202020; padding-bottom: 3px; margin: 0px; }
    #idx a:link    { color: #0066CC; }
    #idx a:visited { color: #0066CC; }
    /*#idx a:hover   { text-decoration: none; }*/
    #idx a:active  { color: #0066CC; }
    #idx td { cursor: pointer;}
    .filenamespan
    {
      white-space: nowrap;
      overflow: hidden !important;
      text-overflow: ellipsis;
    }
    .delete-icon
    {
      position: relative;
      top: 4px;
      color: blue;
      cursor: pointer;
      padding-right: 22px;
      left: -4.5px;
    }
    .options-dropdown
    {
      cursor: pointer;
    }
    .delete
    {
      display : none;
    }
    .rename
    {
      display : none;
    }
    .filecheck
    {
      cursor: pointer;
    }
    .fileoptionsdiv
    {
      margin-left: 39px;
      font-size: 18px;
      color: #0066CC;
    }

    .delete-buttons-div
    {
      margin-top: 10%;
    }
    .navigation
    {
      margin-top: 100px;
      font-size: 18px;
    }
    .file-icon-class
    {
      height: 24.8px;
      position: relative;
      top: -3.5px;
    }
    .hide1
    {
      display: none;
    }
    .hide-download
    {
      position: relative;
      top: -8.5px;
    }
    .actions-dropdown
    {
        font-family: 'Vollkorn', serif;
    }
    @media only screen and (max-width: 571px)
    {
      .hide-for-mobiles
      {
        display : none;
      }
    }
    @media only screen and (max-width: 479px)
    {
      .hide-download
      {
        display: none;
      }
    }
    @media only screen and (max-width: 900px)
    {
        .hide1
        {
            display: none;
        }
        @media only screen and (max-width: 600px)
        {
            .hide2
            {
                display: none;
            }
        }
    }
    @media only screen and (max-width: 977px)
    {
        .hidedate
        {
            display: none;
        }
        @media only screen and (max-width: 834px)
        {
            .hidetype
            {
                display: none;
            }
        }
    }
    .no-items
    {
      font-family: 'IBM Plex Serif', serif;
      font-size: 35px;
      font-weight: bolder;
      color: black;
    }
    .addfiles-swal
    {
      cursor: pointer;
      -webkit-box-shadow:none;
      -moz-box-shadow:none;
      box-shadow:none;
      background-color:#4d90fe;
      background-image:-webkit-linear-gradient(top,#4d90fe,#4787ed);
      background-image:-moz-linear-gradient(top,#4d90fe,#4787ed);
      background-image:-ms-linear-gradient(top,#4d90fe,#4787ed);
      background-image:-o-linear-gradient(top,#4d90fe,#4787ed);
      background-image:linear-gradient(top,#4d90fe,#4787ed);
      border:1px solid #3079ed;
      color:#fff;
      outline:none;
      filter:alpha(opacity=50);
      opacity:1;
      border-radius: 0.13em;
      height: 60px;
      text-align: center;
      padding-left: 5px;
      padding-right: 5px;
      padding-top: 4px;
      padding-bottom: 4px;
    }
    .addfiles-swal:focus 
    {
      -webkit-box-shadow:inset 0 0 0 1px #fff;
      -moz-box-shadow:inset 0 0 0 1px #fff;
      box-shadow:inset 0 0 0 1px #fff;
      border:1px solid #fff;
      border:rgba(0,0,0,0) solid 1px;
      outline:1px solid #4d90fe;
      outline:rgba(0,0,0,0) 0
    }
    .addfiles-swal:active 
    {
 -webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
 -moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
 box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
 background:#357ae8;
 border:1px solid #2f5bb7;
 border-top:1px solid #2f5bb7
}
    </style>
    <script type="text/javascript">
    console.log("Script degug: Working");
    var time_taken_for_php = "<?php echo $end; ?>";
    console.log("Time taken: "+time_taken_for_php);
    var _c1='#fefefe'; var _c2='#fafafa'; var _ppg=100000000000000; var _cpg=1; var _files=[]; var _dirs=[]; var _tpg=null; var _tsize=0; var _sort='date'; var _sdir={'type':0,'name':0,'size':0,'date':1}; var idx=null; var tbl=null;
    function _obj(s){return document.getElementById(s);}  //returns a dom element
    function _ge(n){n=n.substr(n.lastIndexOf('.')+1);return n.toLowerCase();}   //identifies the file type
    function _nf(n,p){if(p>=0){var t=Math.pow(10,p);return Math.round(n*t)/t;}}  //
    function _s(v,u){if(!u)u='B';if(v>1024&&u=='B')return _s(v/1024,'KB');if(v>1024&&u=='KB')return _s(v/1024,'MB');if(v>1024&&u=='MB')return _s(v/1024,'GB');return _nf(v,1)+'&nbsp;'+u;}
    function _f(name,size,date,url,rdate){_files[_files.length]={'dir':0,'name':name,'size':size,'date':date,'type':_ge(name),'url':url,'rdate':rdate,'icon':'index.php?icon='+_ge(name)};_tsize+=size; console.log(url);}
    function _d(name,date,url){_dirs[_dirs.length]={'dir':1,'name':name,'date':date,'url':url,'icon':'index.php?icon=dir'}; console.log(url);}
    function _np(){_cpg++;_tbl();}
    function _pp(){_cpg--;_tbl();}
    function _sa(l,r){return(l['size']==r['size'])?0:(l['size']>r['size']?1:-1);} //sorting based on size
    function _sb(l,r){return(l['type']==r['type'])?0:(l['type']>r['type']?1:-1);} //sorting based on type
    function _sc(l,r){return(l['rdate']==r['rdate'])?0:(l['rdate']>r['rdate']?1:-1);}  //sorting based on date
    function _sd(l,r){var a=l['name'].toLowerCase();var b=r['name'].toLowerCase();return(a==b)?0:(a>b?1:-1);} //sorting based on name
    function _srt(c){switch(c){case'type':_sort='type';_files.sort(_sb);if(_sdir['type'])_files.reverse();break;case'name':_sort='name';_files.sort(_sd);if(_sdir['name'])_files.reverse();break;case'size':_sort='size';_files.sort(_sa);if(_sdir['size'])_files.reverse();break;case'date':_sort='date';_files.sort(_sc);if(_sdir['date'])_files.reverse();break;}_sdir[c]=!_sdir[c];_obj('sort_type').style.fontStyle=(c=='type'?'italic':'normal');_obj('sort_name').style.fontStyle=(c=='name'?'italic':'normal');_obj('sort_size').style.fontStyle=(c=='size'?'italic':'normal');_obj('sort_date').style.fontStyle=(c=='date'?'italic':'normal');_tbl();return false;}

    function _head()
    {
        if(!idx)return;
        console.log("_head() is executed");
        _tpg=Math.ceil((_files.length+_dirs.length)/_ppg);
        idx.innerHTML='<div class="rounded gray" style="padding:5px 10px 5px 7px;color:#202020">' +
            '<div class="row pb-2 float-left"><label class="cont" style="margin-left: 8.5px; margin-top: 5.5px;"><span><input type="checkbox" class="controlling" /><span class="checkmark"></span></span></label><span><div class="ui dropdown simple" style="margin-left: 15px;"><div style="" class="text ml-1 actions-dropdown"><strong>Actions</strong></div><i class="dropdown icon" style="margin-left: 5px;"></i><div class="menu"><div class="item action-file"><i class="upload icon"></i><strong><label for="fileupload" style="cursor: pointer;">File Upload</label></strong></div><div class="item action-folder"><i class="folder icon"></i><strong>New Folder</strong></div><div class="item action-delete"><i class="trash alternate icon"></i><strong>Delete</strong></div><div class="item action-move"><i class="folder open icon"></i><strong>Move</strong></div><div class="item action-rename"><i class="pen square icon"></i><strong>Rename</strong></div></div></div><?=$dir!=''?'&nbsp; (<a href="'.$up_url.'">Back</a>)':''?></span></div>' +
            '<div class="float-right hide-for-mobiles" style="">' +
                'Sort: <span class="link hidename" onmousedown="return _srt(\'name\');" id="sort_name">Name</span>  <span class="link hidetype" onmousedown="return _srt(\'type\');" id="sort_type">Type</span> <span class="link hidesize" onmousedown="return _srt(\'size\');" id="sort_size">Size</span> <span class="link hidedate" onmousedown="return _srt(\'date\');" id="sort_date">Date</span>' +
            '</div>' +
            '<div style="clear:both;"></div>' +
        '</div><div id="idx_tbl"></div>';
        tbl=_obj('idx_tbl');
    }
    function _tbl()
    {
        if (_files.length + _dirs.length == 0)
        {
          idx.innerHTML = "<span class='no-items' style='text-align: ml-5;'>You haven't uploaded any files. <label for='fileupload' style='cursor: pointer;'>Upload</label> to get started</span></br>";
          idx.innerHTML += "<span class='no-items' style='text-align: ml-5;'>OR</span></br>";
          idx.innerHTML += "<span class='no-items' style='text-align: ml-5;'>Create a New Folder</span></br>";
          $("#idx").css("text-align","center");
          return;
        }
        console.log('Debug tbl: Length = '+ _files.length + _dirs.length);
        //_tpg = 1;
        var _cnt=_dirs.concat(_files);if(!tbl)return;if(_cpg>_tpg){_cpg=_tpg;return;}else if(_cpg<1){_cpg=1;return;}var a=(_cpg-1)*_ppg;var b=_cpg*_ppg;var j=0;var html='';
        if(_tpg>1)html+='<p style="padding:5px 5px 0px 7px;color:#202020;text-align:right;"><span class="link" onmousedown="_pp();return false;">Previous</span> ('+_cpg+'/'+_tpg+') <span class="link" onmousedown="_np();return false;">Next</span></p>';
        html+='<table class="main-table" cellspacing="0" cellpadding="5" border="0">';
        if (_dirs.length != 0)
        {
        for(var i=a;i<b&&i<(_dirs.length);++i)
        {
            var x = document.getElementById("content").getBoundingClientRect().width;
            var f=_cnt[i];var rc=j++&1?_c1:_c2;
            var dir_name_length = f['name'].length;
            if (dir_name_length > 12)
            {
              var last__dir_dot = f['name'].lastIndexOf(".");
            }
            html+='<tr class="datarow" style="background-color:'+rc+'"><td class="firsttd"><label class="cont"><span><label>&nbsp;&nbsp;&nbsp;<img class="file-icon-class" src="'+f['icon']+'" alt="" /></label><input type="checkbox" class="dircheck"><span class="checkmark"></span>&nbsp;&nbsp<a data-type="directory" class="navigation" href="'+f['url']+'"><span class="filenamespan">'+f['name']+'</span></a></label></span></td><td class="hide-download"><a></a></td><td class="center hide2" style="width:50px;">'+(f['dir']?'':_s(f['size']))+'</td><td class="center hide1" style="width:70px;">'+f['date']+'</td></tr>';
            c = _dirs.length;
        }
      }
        else
        {
          c = 0;
        }
        for(var i=c;i<b&&i<(_files.length+_dirs.length);++i)
        {
            var f=_cnt[i];var rc=j++&1?_c1:_c2;
            var file_name_length = f['name'].length;
            html+='<tr class="datarow" style="background-color:'+rc+'"><td class="firsttd"><label class="cont"><span><label>&nbsp;&nbsp;&nbsp;<img class="file-icon-class" src="'+f['icon']+'" alt="" /></label><input type="checkbox" class="filecheck"><span class="checkmark"></span>&nbsp;&nbsp<a data-type="file" class="navigation" href="'+f['url']+'"><span class="filenamespan">'+f['name']+'</span></a></label></span></td><td class="hide-download"><a href="'+f['url']+'" download>Download</a></td><td class="center hide2" style="width:50px;">'+(f['dir']?'':_s(f['size']))+'</td><td class="center hide1 date" style="width:70px;">'+f['date']+'</td></tr>';
        }
        tbl.innerHTML=html+'</table>';
        $(document).ready(function(){
          console.log("No.of unchecked boxes: "+$(".filecheck:not(:checked)").length+$(".dircheck:not(:checked)").length)
          $(".action-delete,.action-rename,.action-move").hide();
          $(".controlling").click(function(){
            $(".filecheck,.dircheck").prop('checked', $(this).prop('checked'));
            if (_files.length + _dirs.length == 1 && $(this).prop('checked') == true)
            {
              $(".action-rename,.action-move,.action-delete").show();
            }
            if (_files.length + _dirs.length > 1 && $(this).prop('checked') == true)
            {
              $('.action-rename').hide();
              $(".action-move,.action-delete").show();
            }
            /*if ($(this).prop('checked') == true)
            {
              $(".action-move,.action-delete").show();
            }*/
            if ($(this).prop('checked') == false)
            {
              $(".action-move,.action-delete").hide();
            }
          })
          $(".dircheck,.filecheck").click(function(){
            if ($(this).prop('checked') == false)
            {
              $(".controlling").prop('checked',$(this).prop('checked'));
            }
            else if ($(this).prop('checked') == true && $(".filecheck:not(:checked)").length+$(".dircheck:not(:checked)").length == 0)
            {
              $(".controlling").prop('checked',true);
            }
            if ($(this).prop('checked') == true && $(".filecheck:checked").length + $(".dircheck:checked").length == 1)
            {
              $(".action-rename").show();
              $(".action-delete").show();
              $(".action-move").show();
            }
            if ($(this).prop('checked') == true && $(".filecheck:checked").length + $(".dircheck:checked").length > 1)
            {
              $(".action-delete").show();
              $(".action-move").show();
              $(".action-rename").hide();
            }
            if ($(this).prop('checked') == false && $(".filecheck:checked").length + $(".dircheck:checked").length == 0)
            {
              $(".action-delete").hide();
              $(".action-move").hide();
              $(".action-rename").hide();
            }
            if ($(this).prop('checked') == false && $(".filecheck:checked").length + $(".dircheck:checked").length == 1)
            {
              $(".action-delete").show();
              $(".action-move").show();
              $(".action-rename").show();
            }
          })
        })
    }

    
    <?php
    foreach ($dirs as $j_dir)
    {
      print sprintf("_d('%s','%s','%s');\n",($j_dir['name']),$j_dir['date'],($j_dir['url']));
      //print sprintf("_f('%s','%s','%s','%s',%d);\n",($f['name']),$f['size'],date($date,$f['date']),($f['url']),$f['date']);
    }
    foreach ($files as $j_file)
    {
      print sprintf("_f('%s','%s','%s','%s',%d);\n",($j_file['name']),$j_file['size'],$j_file['date'],($j_file['url']),$j_file['date']);
    }
    ?>

    window.onload=function()
    {
        idx=_obj('idx'); _head(); _srt('name');
    };
    </script>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="material-icons">insert_drive_file</i></div>
                    <div class="sidebar-brand-text mx-3"><span>THYDRIVE</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <input class="fileupload" style="display:none" onchange="upload_function()" multiple name="fileupload" id="fileupload" type="file" />
                    <li class="nav-item upload" id="upload" role="presentation"><label for="fileupload"><a class="nav-link active upload"><i class="fas fa-upload"></i><span>Upload</span></a></li></file>
                    <li class="nav-item createfolder" role="presentation"><a class="nav-link active createfolder" href=""><i class="far fa-folder"></i><span>Create Folder</span></a></li>
                    <li class="nav-item payments" role="presentation"><a class="nav-link active payments" href=""><i class="fas fa-folder"></i><span>Shared to You</span></a></li>
                    <li class="nav-item payments" role="presentation"><a class="nav-link active payments" href=""><i class="fas fa-money-check"></i><span>Payments</span></a></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ..." style="margin-left: 10%;">
                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">Valerie Luna</span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Account</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div id="idx"></div>
                <div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © THYDRIVE 2021</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script>
      function upload_function()
      {
        files = document.getElementById("fileupload").files;
        temp_files = Array.prototype.slice.call(files);
        modifyshow();
        //show += "<label class='cont'><input type='checkbox' class='swal-checbox'><span class='swal-checkmark'></span></label>"
        Swal.fire({
          title: "Upload",
          html : show,
          confirmButtonText: 'Upload',
          showCancelButton: true,
          width: '600px',
          allowOutsideClick: false,
          onOpen: function(){
            if (temp_files.length > 5)
            {
              $(".swal2-confirm").attr("title","Maximum of 5 files can be uploaded at a time");
              $(".swal2-confirm").prop("disabled",true);
            }
            else
            {
              var footer = "";
            }
          },
          preConfirm: () => {
            var form_data = new FormData();
            var fr_data = new FormData();
            enc_file = new File(["Hello there"],"hello.txt");
            for (i = 0; i < temp_files.length; ++i)
            {
              var reader = new FileReader();
              reader.onload = function(e)
              {
                var encrypted = CryptoJS.AES.encrypt(e.target.result, "32175690P");
                console.log(encrypted+"");
                //console.log("Name: "+e.name);
                enc_file = new File([encrypted+""],"test.txt",{type: "text/plain", lastModified: new Date()});
                form_data.append("file"+i,enc_file);
                //console.log(enc_file);
              }
              console.log(enc_file);
              form_data.append("file"+i,enc_file);
              reader.readAsDataURL(temp_files[i]);
              file_data = temp_files[i];
              fr_data.append("file"+i,file_data);
            }
            console.log(fr_data);
            $.ajax({
              url : 'upload.php',
              dataType: 'text',
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              type: 'post',
              success: function(result)
              {
                console.log(result);
              }
            })
          }
        })
      }
      function modifyshow()
      {
        //console.log(files[0]);
        if (temp_files.length == 0)
        {
          show = "<span style='overflow: scroll;'><span><strong>Add some files to upload</strong></span></br></br></br>";
          show += "<span><label class='cont-add' style='text-align: left; width: 55%; white-space: nowrap; display: inline-block;'><input type='file' multiple style='display: none;' onchange='add_files_to_upload()' class='addfiles' name='addfiles' id='addfiles' /><label for='addfiles'><span class='addfiles-swal'>Add files</span></label></label></span></br></br>";
          show += "</span></br>";
          $(".swal2-html-container").html(show);
          $(".swal2-confirm").prop("disabled",true);
          $(".swal2-confirm").attr("title","No files selected to upload");
          //console.log("Zero element array");
          return;
        }
        show = "<span style='overflow: scroll;'><span><strong>Select the files you wanted to encrypt</strong></span></br></br></br>";
        for (i = 0; i < temp_files.length; ++i)
        {
          if ((temp_files[i].name).length > 17 && $(window).width() >= 700)
          {
            temp = (temp_files[i].name).substr(0,16);
            temp += "...";
          }
          else if (temp_files[i].name.length > 7 && $(window).width() < 420)
          {
            temp = (temp_files[i].name).substr(0,7);
            temp += "...";
            console.log(temp);
          }
          else
          {
            temp = temp_files[i].name;
          }
          show += "<span><label class='cont' style='text-align: left; width: 55%; white-space: nowrap; display: inline-block;'><input type='checkbox' class='swal-checkbox'><span class='swal-checkmark'></span><span class=''>"+temp+"</span>&nbsp;&nbsp;</label><span data-number="+i+" class='fa fa-close text-nowrap removefile' onclick='crossclick(this)' style='font-size: 20px; white-space: nowrap; display: inline-block; cursor: pointer;' data-name="+temp_files[i].name+"></span></span></br></br>"
        }
          if (temp_files.length > 5)
          {
            $(".swal2-confirm").attr("title","Maximum of 5 files can be uploaded at a time");
            $(".swal2-confirm").prop("disabled",true);
          }
          else if (temp_files.length <= 5)
          {
            $(".swal2-confirm").prop("disabled",false);
          }
          show += "<span><label class='cont-add' style='text-align: left; width: 55%; white-space: nowrap; display: inline-block;'><input type='file' multiple style='display: none;' onchange='add_files_to_upload()' class='addfiles' name='addfiles' id='addfiles' /><label for='addfiles'><span class='addfiles-swal'>Add files</span></label></label></span></br></br>";
          show += "</span></br>";
        //show += "<span><label class='cont' style='text-align: left; width: 55%;'><span style=''><span class='addfiles-swal'>Add more</span></span></label></span></br>"
        $(".swal2-html-container").html(show);
        //console.log("Width: "+$(window).width());
      }
      function add_files_to_upload()
      {
        //console.log("Function to add, executed");
        extra_files = document.getElementById("addfiles").files;
        //console.log(extra_files);
        extra_files_array = Array.prototype.slice.call(extra_files);
        //console.log(extra_files_array);
        //console.log("Extra files: ");
        //console.log(extra_files);
        temp_files = temp_files.concat(extra_files_array);
        modifyshow();
        var encryptedAES = CryptoJS.AES.encrypt("Message", "My Secret Passphrase");
        var decryptedBytes = CryptoJS.AES.decrypt(encryptedAES, "My Secret Passphrase");
        var plaintext = decryptedBytes.toString(CryptoJS.enc.Utf8);
        console.log(encryptedAES+" "+decryptedBytes+" "+plaintext);
      }

      function crossclick(x)
      {
        var index = $(x).attr("data-number");
        //console.log(index);
        temp_files.splice(index,1);
        modifyshow();
        //console.log(temp_files);
      }
    </script>
    <script>
    </script>
    <script src="https://storage.googleapis.com/instant-static-files/js/theme.js"></script>
</body>

</html>