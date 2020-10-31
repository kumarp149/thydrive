<?php
session_start();
/*if (! isset($_SESSION['emailid']) || ! isset($_SESSION['pwdentered']))
{
  header('Location: http://mathlearn.icu');
  die();
}*/
@ob_start('ob_gzhandler');
if(isset($_GET['icon']))
{
    $e=$_GET['icon'];
    $I['file']='R0lGODlhEAAPAOYAAIyMlu7u9PHx9vDw9fT0+PPz97u7vvf3+vb2+d/f4vn5+/39/vv7/Pr6+/b29+3t7pCRnI6PmZOVn5ibpZWYopqeqJ2hq6KnsaClr9fZ3ff4+t/g4qSqtKmwuqeuuM3P0vHz9tze4be6vuzv8+vu8urt8eXo7Kuzva61vquyu9/k6uXp7uTo7cvU3dHZ4dDY4Nfe5d3j6dzi6Nvh5+Po7eLn7OHm69HV2ejs8Ofr7+7x9OHk597h5PT2+PP19/Hz9evt7+Lk5t3f4fr7/Pn6+/b3+PX299Tc49rh5+ru8fDz9ff5+vb4+fP19vz9/f////7+/vv7+/Pz8+/v7+zs7Orq6ubm5uHh4d7e3sDAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAFkALAAAAAAQAA8AAAevgFmCJ4SFhDuCiYIdUI1QDQ9NKCGKgh4LjQsOG0smKRmVHAxPUAtGQktLPxxTihcKjU5FQR8iBhdXihgHC05DTEA8NwkYWIoWCENEGj1KJCsIFsaJFQRMPT5KIzk2BBXTghMFIEo6JDk1MQUT4FkUAiVJOCs2MTACFO0SAyw0NiozYLgYIKEdhAAyZiCBceRFiwAQ2kUIQLFixQjtAGjcyBFAuyhSqFgZSXJklSyBAAA7';
    $I['dir']='R0lGODlhEAAOAOYAAP79uv//4/j43f//5f7+5v7+6f//7f//7//8qf/9vf/9wf/+xP/9yf793P/+4f32hP/6iv/6pP/9zP/4kf/4nP/4n/373//1jf/2nP32tvnodfzuff/xhv/3uP/revftrvz32v/ocf/odP/rhPnz0/z44+DAPOHAPe/gnPXrvv3zyM6hAMicAMeaANStJdu4PNy7RODDWN7EaOLIauLIa//10ffuzcudAMiaAMSWAMOVAMGTAL2PALqMAMilLtayPNe2TNW0TNKxTNm7V9e5V82vU9zEd+7jvurfvPXryfbu072NALiKALaIALOEALKDALGCAK+AAMinRMalRMOiRNCuTM6sTMuqTMmnTLyfUdm8ZtW9et3Kl+XUoa19AKp6AK6EG7GHIr2YNr+cQ7iXQ8akTMSjTb6jXs2waMOqbNjEkNDDpM2xctfQwPz8/Pv7+/r6+vX19fHx8ezs7Ovr6+jo6Ofn5+bm5uHh4eDg4N/f397e3t3d3cDAwAAAAAAAACH5BAEAAH0ALAAAAAAQAA4AAAe4gEkzMkNERl19iYqKMSkGjwZbRVJTVGhqijACEJwQEpCPWXKJOBYPp6ioFjh2bn06IBuys7MgOnpwfTwkGiY/QEFCVVZXWGVmYl9MNic0BwHQ0QMOBUhgT0cuJQoJ3d4LAARja15aKAwI6QgRFRQYGVxke1AvDRMXHB4iIfwjSmFt6iz50KGGwYMGVbBJgyeODxYrbrTIsYNHjyZOopzhM8fVHT17QooUmYdOrj5v4KhcyRKOqz6BAAA7';
    $I['doc']='R0lGODlhEAAQAPcAAAEyeCg+bQgviwU2ggg8iAZCmwlLsiFMmjpamDJbtipitzhhrjppuE1qp0BmtERquVVtpF11q2d+s0JuxEl0zFJ3ylV7zl99w1h+0XeKnG6Ov3KQv3KRv3aTvXqVu3uVvH6XulWAyFmBxliCxV2ExF6ExGCBzWGIw2KJw2WKwmeLwWmMwWyOwGeK1XeR1XyX2P8A/4KavIWdvoOc2oCe5oigwIuiwoyiwouk3ZGnxpesyZCu1p2xzYml6ZOr5qO20am71K260K+836q+8a/A2LPD2rfI9MnS4tbc6tLi+tTj+tbk+tfl+9zi9Nnm+9vn+9zo+97p++Dq/OHs/OPt/OXu/Obv/Ojw/erx/evy/e3z/e/0/fDy+vD2/vL3/vT4/vX5/vf6/vn7/////wCpEQAAABLs7NS5srGlQNcVPRQCgBQCQBLtDNdNrxQCgGQCeNdN4xQCgBLtFAAAAJEFyCNr8BLt4JEFURQHqJEFbRLuOAAAABLtPAAAAJEFyFiHuBLuCJEFURQHSBLtWAAAAJEFyFiHuBLuJJEFURQHSJEFbRLuaAAABAAAAOaERAAAAgAABAAAMAAAACNr+NSLsf3QAAAAMAAABBQAABLrmJD7bAAAIAAAAFiHwBLuOAAAAAAAIADwqgAAIAAAAAAAAJDnvJDVhhLuCJD7bJD7cZDVhpDnvBQAABLt5JDnyBLujJDuGJD7eAH//wAABBLtaAAAABLujJDuGJEFcP///5EFbZEJvBQAAAAAAFiHwBLuSJEJkliHwAAAABLunN3tDt3tIGKmyAABxGKm1AAAAAAAAAAAAAAAAAAAABLuaBLu7BS3YBS3YBLuoOb8I8OlLsYaoBLu2MLCzQAABMLC4xS04BS3YAAAAxSwbsXS4BSwABLu1BLupP///xLvQMNclMEgcP///8LC40SV1RS3YGMboGMboEUEtRQAABS04IoASAAAAAAAAOqG1OqG1OqG1OqG1AAC8BLvJN1sdBLvLIoASIoASObgowAACeaCsAAABCH5BAEAADAALAAAAAAQABAAAAjhAGEILALkBw8dOWzIAAFCoEMYRMSEAfPFS5ctIMY0hOHDRw8aL1pgqDBBgZaMGjmOWclypYEsKDX2GDLDBBITTSDgMICFoU8aTWZcaPKgSYMMBq5YqUJlCggXY1w8EHIAB4IjBZY2lQKixRgJDyIMSBBgTIEqO3ZIieLBwhgICIwMGBBkDIGtUaB0oDBGwAIuAxysHDAlLZQnGxi0bAlg7WEnLBQYmFygMoEBAKKkdcJEhcMbWqc4fsJ5CQqHNZimXZ12iZISDmXgfczEdRIRDmN8+NCBg4YVKU6QGBEiREAAADs=';
    $I['xls']='R0lGODlhEAAQAPcAADVJGjRNGTVNGDRSFzRTFzRYFTReEzReFDVeGjNpDzNtDjRtDjRjETRkEjZjGztoHjpvHjNwDTlwHjp3GTx3Hz57HjJoKDtxIjp9Jz99IWB+XEKAJUaELEeFLUKJNUeIO02MNk+OOUiSP1OTQFKXSFiYR1qaSVieUl6YVV+hU1uiWHCbbWGiVGGgWGWnW2eqX2SoYGmtYmqsZW2wZ3SlcG6Ov3KQv3KRv3aTvXqVu3uVvH6XulWAyFmBxliCxV2ExF6ExGGIw2KJw2WKwmeLwWmMwWyOwP8A/4KavIWdvoephZC9i5ywm6Gzn4igwIuiwoyiwpGnxpesyZCu1p2xzaO20am71JPCjpPEjZbEkZrGlq/A2LPD2sDRwMzay8/dz9bi1t/p39Li+tTj+tbk+tfl+9nm+9vn+9zo+97p++Xs5eDq/OHs/OPt/OXu/Obv/Ojw/erx/evy/e3z/e/0/fD2/vL3/vT4/vX5/vf6/vn7/////xLtPAAAAJEFyCLVGBLuCJEFURQHSBLtWAAAAJEFyCLVGBLuJJEFURQHSJEFbRLuaAAABAAAAOaERAAAAgAABAAAMAAAAFeQiNSLsf3QAAAAMAAABBQAABLrmJD7bAAAIAAAACLVIBLuOAAAAAAAIADwqgAAIAAAAAAAAJDnvJDVhhLuCJD7bJD7cZDVhpDnvBQAABLt5JDnyBLujJDuGJD7eAH//wAABBLtaAAAABLujJDuGJEFcP///5EFbZEJvBQAAAAAACLVIBLuSJEJkiLVIAAAABLunN3tDt3tIGKmyAABwGKm1AAAAAAAAAAAAAAAAAAAABLuaBLu7BSuABSuABLuoOb8I8OlLsYaoBLu2MLCzQAABMLC4xSsQBSuAAAAAxSg2MXS4BSgABLu1BLupP///xLvQMNclMEgcP///8LC40SV1RSuAGMboGMboEUEtRQAABSsQKR+UAAAAAAAAOqG1OqG1OqG1OqG1AACBBLvJN1sdBLvLKR+UKR+UObgowAACeaCsAAABCH5BAEAAEcALAAAAAAQABAAAAjhAI8I5GKlChUpUZ4k2bFDoMMjW/TkwXPHTh06O/Y0PDIjhosUJkaA6LChwpyMGjnuWclyZQQ5KDXOuAKDxB4vKFAwURCHoc8XarDI8ECjxQcwCeC8cdOGzQ4We75oUYHBQpc9DJY2XbOjxJ4lJ7KouLAizAE3U6asSZMjxBIKEBwsEfGgSYGtadDg4NBSiQQEGgawSYvmjI0MLVsKWFvYjJEJERYkaGCgAIEAANKkNVOGiEMoWtkwPsOZjBCHTpimXZ2WzBggDpPgbVzGtZgeDpHo0IHjRo0iQ4L88MGDR0AAADs=';
    $I['jpg']=$I['gif']=$I['png']='R0lGODlhEAAQAPcAAPuBhP0RI9fU1r24vL25vn+CmKSxzLfF4cPL28bO3srO1oOk4WF4opyuzpWlwpurx6i30qm30ae1zqa0zb3M57G/2Kq3z6m2zcTR6aSvw9Dd9crW7NPe8tXg88PM3OLs/tXe7+Lr/Njh8eHp98/W4wBe9Yibup+vyZemv6e2z6e2zsXW8rLC26e1zK+91Kezx8jU6Nvo/eDr/dzm9uLs/OTt/MvT4ODn897l8dvi7uvy/gxn7Keyw7K9zsTQ4uPu/t7p+dzm9c/Y5t7n9dri7svb8djh7ejw++vw9+fs87jI2+Hu/lem/vH3/lSp/uTx/vP5/snj9+33/qGoqPz+/v3+/lXSYAC1AH3GdS6qHnDIW1OmL+Hp173JqoGaKby9srurRv3slf7dbf7cc/7Xb/7QZ/3SdP7FVd6wUP7LaP6/SP68SeS7cv6vMP62QNycN+KuWOCuW/vt1fueGf6qL/6vN/6xOf65V+C/jP2XEv6eGvmeH/6gI/6iJOCSKM+WR9ScUPjEff6ZG8qELbB/ROG0f/2EAPeAAf6IAuR5BP6JCP6QENKTTdmseuC7kbBhEKlfFa5iGMR0I8d+M45aJr6BRM2VW9ikcNuugNG8pvLk1v37+f17AO1zAKlUBrNiFqBdHplZHr97PcB/Q690Pc6KTcWHT7F9T9CYY9Opg9KujN25l6NJAJJFBK5sMpNnQcqcdKaGbL+fhPfw6qpKALeDWtijebGReOC4mdm2nKuQe+XDqfjy7tm0nedXBa+ZjPjz8OfOwauSh/BvO/55QcY0AN7a2d4dA+kwFdsTBv7+/v///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAMsALAAAAAAQABAAAAj/AJcJXIbDSI6DREDAQKBs4MAgVZRJVNaEwwYbDgUaozJRGZQON46QcLgplaNLmFZpoiLDh5AKHgTuKmVJlzBVqEbBSlIEQgMTy2wxkhOFiZMFXLoQOiWCwgEHuCQ1KvRlRwkGWqxgERVrBYYHkwAF68VmSgE8Wa5sCRQqgYYTg8LEgWOGTJk0YLz8uQOJQAwDptCMEXNmjZs6dIgBGOZpwJIJs3JVeqPGDp0+c5AFSNZKwQ8JAnnV8tOGj6A8vo4VozTjg4qBwFzt0bNIESJDrH49oZHCoaxHiQ5x6kTr1QggIXoPFJCJVKRPoG4hkVJDRwSHQ5T04JHhBQsXF1pYA0AREAA7';
    $I['txt']='R0lGODlhEAAQAPcAAB6Kcm6Ov3KQv3KRv3aTvXqVu3uVvH6XulWAyFmBxliCxV2ExF6ExGGIw2KJw2WKwmeLwWmMwWyOwP8A/4KavIWdvoigwIuiwoyiwo+lxJGnxpKoxpWryJesyZmtypCu1p2xzaO20am71K/A2LPD2tLi+tTj+tbk+tfl+9nm+9vn+9zo+97p++Dq/OHs/OPt/OXu/Obv/Ojw/erx/evy/e3z/e/0/fD2/vL3/vT4/vX5/vf6/vn7/////xLuYAAAQAAAAAAAABLuqBLuaAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQBLurJDuGAAAAAAAAgAAAQACEBLuYAACEJEZcAa6SAa6KAAAAAAAAAHskAABHhLsBJDuGBLswNS5TACpEQCpERLs1NS47q0nqACpEQAAABLs7NS5sq0nqNcVPRQCgBQCQBLtDNdNrxQCgCoFBtdN4xQCgBLtFAAAAJEFyCLqgBLt4JEFURQHqJEFbRLuOAAAABLtPAAAAJEFyAcKIBLuCJEFURQHSBLtWAAAAJEFyAcKIBLuJJEFURQHSJEFbRLuaAAABAAAAOaERAAAAgAABAAAMAAAACLqiNSLsf3wAAAAMAAABBQAABLrmJD7bAAAIAAAAAcKKBLuOAAAAAAAIADwqgAAIAAAAAAAAJDnvJDVhhLuCJD7bJD7cZDVhpDnvBQAABLt5JDnyBLujJDuGJD7eAH//wAABBLtaAAAABLujJDuGJEFcP///5EFbZEJvBQAAAAAAAcKKBLuSJEJkgcKKAAAABLunN3tDt3tIGKmyAABsGKm1AAAAAAAAAAAAAAAAAAAABLuaBLu7BR5EBR5EBLuoOb8I8OlLsYaoBLu2MLCzQAABMLC4xR2sBR5EAAAAxRwicXS4BRwABLu1BLupP///xLvQMNclMEgcP///8LC40SV1RR5EGMboGMboEUEtRQAABR2sIPdOAAAAAAAAOqG1OqG1OqG1OqG1AABsBLvJN1sdBLvLIPdOIPdOObgowAACeaCsAAABCH5BAEAABMALAAAAAAQABAAAAipACcIJCEiBIgOGi5UOHBAoMMJI3js0JEDxw0bB3o0nACgo8ePHXto5CiyBwCTKEuKPBCypcmTABgybEkTJowXLljChPnSJM4WOkGCbNGCRQGHHmrQmCEjxk0XRVcQcMhh6YerWD+sUCHA4QamTn+y2JpCgsMMTbNiTYECgkMMYaGOVcH2hAOHFm6qvXrCBAOHFcSSRdG3RAKHFAwYIDAgQIQHDRYoQIAgIAA7';
    $I['avi']=$I['mpg']=$I['mpeg']=$I['mp3']='R0lGODlhEAAQAPcAAEhHSHd2d//+/+/q9+7r9KalqPLx9NrZ3HZ1e4mJjx0dHoeHi+Dg4/n5++np6+jo6tLS1NjY2ZqamxYelholkUBHhIWGjHB2lREwshozpCdDujZPuoOEiIWNqBI7tJWWmdTV2B1NwihTuC9iyDZqzlF60X+Vw/z9/xtbyxZczvb5/h1m0EqA0EZ/z1aP3srd9h502hh24VSc6SuD3oqLjNfY2SGN70ik6cHe9ODn6urv8MTGxnG+AYTVDXiuKaPOX6DEZ+nu4XO3AWWgAU56AYypWoWWaNPcw22pAWacAVyKCTpTCm2bFF+BHHehLEVnAWGNBk9zBXWDV1BhKsbKvZm0VajRMHKKKJG5AUlaBnp9b4ulGoqMgYiIhoKCgLOzseDg325qVf/++dqvAdmvAei7As2oBtCoB8qlB+jAF+jAG6eLE5yDGezHK+fFN4RyIN7AOOTEOuPDO4BuIu3MQ+XIR+rLSuXHSOXHSu3VaO3Wc+7YeIuFa/ry0vz343lxVn16cnh2cMHAvpOOiPjx6evq6eHc2v9zTfV6WfnRxuHLxfvx7v9KG/lHG/hIG/lOIvxNI/dOJP5ZLv5aMexYMvVeOPRjPv9xTP92U/BzU/99Xet2WPKijvWvnu+unvGxofnMwNvLx/r19P////v7+/Ly8uzs7Ojo6Obm5uTk5OLi4uDg4N/f39jY2NbW1tLS0s/Pz87Ozs3NzczMzMfHx7Ozs62traenp56enpycnJqamnl5eWtra2RkZE5OTiEhIRwcHBsbGxMTEwgICAQEBP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAMUALAAAAAAQABAAAAj/AIsJXMRpE6UtPopQMSCwYTFQlRpBeoSFxxAlRg44TBRpEiZNiKz0EJKEiBQIAkVZkoTpU6gINY78QALlCRdVxTw5utSJEK8dDggMAMIkypQCpDIxOqSIEABeu2gJCOKkyRIvq5QeMuTU169hvR5UuZJFC6wWM27kcBqMGDBYDPLAMcNnFosYNnAQUiDsFqwTfuy4OQNolokUMGToGCSowahRe+6oWWMhFggRKFa4eKFCTB89deSM+SOBVbEOHkKMIFGCDh08ccq8+WBLYKELGTBo2NCmTRoyczjkStUQTIIKFCagQcMmDA1crRwWK/WlC4JAARboqnVKekNTrmTJBnqFapTDgAA7';
    $I['pdf']='R0lGODlhEAAQAPcAAFoAAGMAAHMYGG6Ov3KQv3KRv3aTvXqVu3uVvH6XulWAyFmBxliCxV2ExF6ExGGIw2KJw2WKwmeLwWmMwWyOwIwACJQAAJwhIa0ACLUAAL05OZxCQr1KSr1SWsYAAM4ICM4QENYYGM4pMd45OecIEPcQEPcYGO85OfcpKf8xOc5KSt5KStZja+dKSu9CSu9KSudaWu9SUu9SWudaY+dzc+97e/9zc/8A/4KavIWdvoigwIuiwoyiwo+lxJGnxpKoxpWryJesyZmtypywzJ2xzaO20am71Ky+1q/A2LPD2t6EhN61veeMjO+cnO+trdLi+tTj+tbk+tfl+9nm+9vn+9zo+97p++/W1ufv9+Dq/OHs/OPt/OXu/Obv/Ojw/erx/evy/e3z/e/0/fD2/vL3/vT4/vX5/vf6/vn7/////xQCgBQCQBLtDNdNrxQCgBEGqNdN4xQCgBLtFAAAAJEFyCJ8mBLt4JEFURQHqJEFbRLuOAAAABLtPAAAAJEFyFWi2BLuCJEFURQHSBLtWAAAAJEFyFWi2BLuJJEFURQHSJEFbRLuaAAABAAAAOaERAAAAgAABAAAMAAAACJ8oNSLsf3QAAAAMAAABBQAABLrmJD7bAAAIAAAAFWi4BLuOAAAAAAAIADwqgAAIAAAAAAAAJDnvJDVhhLuCJD7bJD7cZDVhpDnvBQAABLt5JDnyBLujJDuGJD7eAH//wAABBLtaAAAABLujJDuGJEFcP///5EFbZEJvBQAAAAAAFWi4BLuSJEJklWi4AAAABLunN3tDt3tIGKmyAACvGKm1AAAAAAAAAAAAAAAAAAAABLuaBLu7BSjUBSjUBLuoOb8I8OlLsYaoBLu2MLCzQAABMLC4xSo8BSjUAAAAxSgLcXS4BSgABLu1BLupP///xLvQMNclMEgcP///8LC40SV1RSjUGMboGMboEUEtRQAABSo8KR+UAAAAAAAAOqG1OqG1OqG1OqG1AACXBLvJN1sdBLvLKR+UKR+UObgowAACeaCsAAABCH5BAEAADcALAAAAAAQABAAAAjcAG8ITGKkCJEgPnbkSJBAoMMbSNCcMVOGzBgxCdI0fHhkYsWLYTJqvNGBgwYVM2DIgOFCBBiRGm28SIHChIkSJkhg+MKw54kQIEB4+OABQ4YKXrpw2aIlgYUAAARsmLrhwgalTLNsvDFETBgwX1Zg1ZLFygGHQr5+uTKiSVYrVQw4BALWSw0sTJyUrUKFgMMfX7xcaeHEyYoWMZRMoeCwR1IYS8jCXcJCigSHPLrMYCKZ7xQpUSA41EGDRmcqn6NAceAwx1vPoKE8WeAQBwIEBgoMmBDhQQMGChQEBAA7';
    $I['rar']=$I['zip']='R0lGODlhDwAQAOYAAMjY9gRLsBJPqRZQpydpx7TP9iFbrSNfsChltixquzt6xEmH0VqU2G2h4HSk4HGc05jC9ZCz3jmF1zqA0EOK106P2JC235S335a535i531am9FOa5FOa4l2l61uZ13Cv7ne09IKx3ziZ81yr9mGz/2i3/2Go62as7XK7/26x7ni+/3W38Ha38HKx5nu88XWx5IjD84HA8oTD84vK+ZvP9YnJ963b+bzl+8fs/fT///79mf//r///uf//xPr2k//9pP/4hv/6kPr1kPr1kf/7mvfvgvPkbdm/Ktm/LPn25dm8L/vwvfvzzt61AfbNLNm3KfzUMdm3Mdu5M9q6Nd6+O/3ZR/vdZPzkhfvnl/roodq0Kv7TOP3VOf3aUfzZWPzebfvedPziffrjj/rprfrrs/juytKgB9SjCNWlC8+hDtWmEM+hENKmFNWmFtSnG9WqH9SqH9WqIdWrItiuKOjRh7J9DrR8D7mFKaptDbJ7I6ttDax0HfEZAf///wAAAAAAACH5BAEAAH0ALAAAAAAPABAAAAe8gH2CgzIxLispJyaCdGmOdCY5ODc2NDAsC31pfJxpBJ+gEyMeAWtaT0dISlFSU1R2fSEvAXI6PTw7P0RBQEZ1fRYyAW8+SWVjYmBeW02/GDMBcENMZFhhVlVQzX3P0dPV19nbF9BxQktZV19dXE7bGTUBbEVzbm1qaGdm2xEtAXd59ODZAwrUgw8dAgwStKgECRQqVHRQsHCQiQQIDhwwoLCiRxOLPA7i4KABgwoUJAgQuQFAAQggNIgYEAgAOw==';
    header('Cache-control: max-age=2592000');
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T',time()+2592000));
    header('Content-type: image/gif');
    print base64_decode(isset($I[$e])?$I[$e]:$I['file']);
    exit;
}
if (isset($_GET['dir']))
{
  $dir = $_GET['dir'];
}
else
{
  $dir = '';
}
$sitename='Files';
$date='M-d-y'; // date format
$ignore=array('.','..','.htaccess','index.php','icon.php','Thumbs.db','web.config','index.php','process.php','files1.php'); // ignore these files
// End configs
$root=dirname(__FILE__);
$dir=isset($_GET['dir'])?$_GET['dir']:'';if(strstr($dir,'..'))$dir='';
$path="$root/$dir/";
$dirs=$files=array();
if(!is_dir($path)||false==($h=opendir($path)))exit('Directory does not exist.');
while(false!==($f=readdir($h)))
{
    if(in_array($f,$ignore))continue;
    $URL = dirname($_SERVER["REQUEST_URI"]);
    /*echo $URL."</br>";
    echo $_SERVER["REQUEST_URI"];
    die();*/
    /*if(is_dir($path.$f))$dirs[]=array('name'=>$f,'date'=>filemtime($path.$f),'url'=>"$URL"."/".rawurlencode(trim("$dir/$f",'/')).'/index.php');*/
    if (strpos($_SERVER['REQUEST_URI'],"index.php") != null)
    {
      /*echo $_SERVER['REQUEST_URI'];
      die();*/
      if(is_dir($path.$f))$dirs[]=array('name'=>$f,'date'=>filemtime($path.$f),'url'=>"$URL"."/".rawurlencode(trim("$dir/$f",'/')).'/');
      else$files[]=array('name'=>$f,'size'=>filesize($path.$f),'date'=>filemtime($path.$f),'url'=>trim("$dir/".rawurlencode($f),'/'));
    }
    else
    {
      /*echo $_SERVER['REQUEST_URI'];
      die();*/
      if(is_dir($path.$f))$dirs[]=array('name'=>$f,'date'=>filemtime($path.$f),'url'=>$_SERVER['REQUEST_URI'].rawurlencode(trim("$dir/$f",'/')).'/');
      else$files[]=array('name'=>$f,'size'=>filesize($path.$f),'date'=>filemtime($path.$f),'url'=>trim("$dir/".rawurlencode($f),'/'));
    }
}
closedir($h);
$current_dir_name = basename($dir);
$up_dir=dirname($dir);
$up_url=($up_dir!=''&&$up_dir!='.')?'/'.rawurlencode($up_dir):'index.php';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Brand</title>
    <link rel="stylesheet" href="http://mathlearn.icu/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <style type="text/css">

    a { cursor : pointer; }
    #idx { border: 3px solid #fff; margin-left: 2%; margin-right: 2%; font-size: 20px; min-width: 50px;}
    #idy { border: 3px solid #fff; margin-left: 2%; margin-right: 2%; font-size: 20px; min-width: 50px;}
    #idy p { padding: 0px; margin: 0px;line-height:1.4em;}
    #idy p.left { float:left;width:60%;padding:3px;color:#606060;}
    #idy p.right {float:right;width:35%;text-align:right;color:#707070;padding:3px;}
    #idy a:hover { text-decoration: none; }
    #idy a:link    { color: #0066CC; }
    #idy a:visited { color: #0066CC; }
    #idy a:hover   { text-decoration: none; }
    #idy a:active  { color: #0066CC; }
    #idy strong { font-family: "Trebuchet MS", tahoma, arial; font-size: 1.2em; font-weight: bold; color: #202020; padding-bottom: 3px; margin: 0px; }
    #idx td.center { text-align: center; }
    #idx td { border-bottom: 1px solid #f0f0f0; }
    #idx img { margin-bottom: -2px; }
    #idx table { color: #606060; width: 100%; margin-top:3px; }
    #idx span.link { color: #0066DF; cursor: pointer; }
    #idx .rounded { padding: 10px 7px 10px 10px; -moz-border-radius:6px; }
    #idx .gray { background-color:#fafafa;border-bottom: 1px solid #e5e5e5; }
    #idx p { padding: 0px; margin: 0px;line-height:1.4em;}
    #idx p.left { float:left;width:60%;padding:3px;color:#606060;}
    #idx p.right {float:right;width:35%;text-align:right;color:#707070;padding:3px;}
    #idx strong { font-family: "Trebuchet MS", tahoma, arial; font-size: 1.2em; font-weight: bold; color: #202020; padding-bottom: 3px; margin: 0px; }
    #idx a:link    { color: #0066CC; }
    #idx a:visited { color: #0066CC; }
    #idx a:hover   { text-decoration: none; }
    #idx a:active  { color: #0066CC; }
    #idx td { cursor: pointer;}
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
    .deleteprompt
    {
      display: none;
      color: black;
      position: absolute;
      z-index: 1;
      text-align: center;
      left: 33%;
      right: 33%;
      top: 7%;
      height: 250px;
      display: ;
      background-color: white;
    }
    .delete-buttons-div
    {
      margin-top: 10%;
    }
    @media only screen and (max-width: 900px)
    {
      .deleteprompt
      {
        display: none;
        color: white;
        position: absolute;
        z-index: 1;
        text-align: center;
        left: 30%;
        right: 30%;
        top: 7%;
        height: 200px;
        display: ;
        background-color: black;
      }
      @media only screen and (max-width: 750px)
      {
        .deleteprompt
        {
          display: none;
          color: white;
          position: absolute;
          z-index: 1;
          text-align: center;
          left: 25%;
          right: 25%;
          top: 7%;
          height: 200px;
          display: ;
          background-color: black;
        }
        @media only screen and (max-width: 550px)
        {
          .deleteprompt
          {
            display: none;
            color: white;
            position: absolute;
            z-index: 1;
            text-align: center;
            left: 20%;
            right: 20%;
            top: 7%;
            height: 200px;
            display: ;
            background-color: black;
          }
        }
        @media only screen and (max-width: 480px)
        {
          .deleteprompt
          {
            display: none;
            color: white;
            position: absolute;
            z-index: 1;
            text-align: center;
            left: 16%;
            right: 16%;
            top: 7%;
            height: 200px;
            display: ;
            background-color: black;
          }
        }
        @media only screen and (max-width: 390px)
        {
          .deleteprompt
          {
            display: none;
            color: white;
            position: absolute;
            z-index: 1;
            text-align: center;
            left: 13%;
            right: 13%;
            top: 7%;
            height: 200px;
            display: ;
            background-color: black;
          }
        }
        @media only screen and (max-width: 360px)
        {
          .deleteprompt
          {
            display: none;
            color: white;
            position: absolute;
            z-index: 1;
            text-align: center;
            left: 10%;
            right: 10%;
            top: 7%;
            height: 200px;
            display: ;
            background-color: black;
          }
        }
        @media only screen and (max-width: 335px)
        {
          .deleteprompt
          {
            display: none;
            color: white;
            position: absolute;
            z-index: 1;
            text-align: center;
            left: 8%;
            right: 8%;
            top: 7%;
            height: 200px;
            display: ;
            background-color: black;
          }
        }
      }
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
    </style>
    <script type="text/javascript">
    <!--
    var _c1='#fefefe'; var _c2='#fafafa'; var _ppg=100; var _cpg=1; var _files=[]; var _dirs=[]; var _tpg=null; var _tsize=0; var _sort='date'; var _sdir={'type':0,'name':0,'size':0,'date':1}; var idx=null; var tbl=null;
    function _obj(s){return document.getElementById(s);}
    function _ge(n){n=n.substr(n.lastIndexOf('.')+1);return n.toLowerCase();}
    function _nf(n,p){if(p>=0){var t=Math.pow(10,p);return Math.round(n*t)/t;}}
    function _s(v,u){if(!u)u='B';if(v>1024&&u=='B')return _s(v/1024,'KB');if(v>1024&&u=='KB')return _s(v/1024,'MB');if(v>1024&&u=='MB')return _s(v/1024,'GB');return _nf(v,1)+'&nbsp;'+u;}
    function _f(name,size,date,url,rdate){_files[_files.length]={'dir':0,'name':name,'size':size,'date':date,'type':_ge(name),'url':url,'rdate':rdate,'icon':'index.php?icon='+_ge(name)};_tsize+=size;}
    function _d(name,date,url){_dirs[_dirs.length]={'dir':1,'name':name,'date':date,'url':url,'icon':'index.php?icon=dir'};}
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
        _tpg=Math.ceil((_files.length+_dirs.length)/_ppg);
        idx.innerHTML='<div class="rounded gray" style="padding:5px 10px 5px 7px;color:#202020">' +
            '<p class="left">' +
                '<strong><?=$current_dir_name==''?$sitename:$current_dir_name?></strong><?=$dir!=''?'&nbsp; (<a href="'.$up_url.'">Back</a>)':''?><br />' +
            '</p>' +
            '<p class="right">' +
                'Sort: <span class="link hidename" onmousedown="return _srt(\'name\');" id="sort_name">Name</span>  <span class="link hidetype" onmousedown="return _srt(\'type\');" id="sort_type">Type</span> <span class="link hidesize" onmousedown="return _srt(\'size\');" id="sort_size">Size</span> <span class="link hidedate" onmousedown="return _srt(\'date\');" id="sort_date">Date</span>' +
            '</p>' +
            '<div style="clear:both;"></div>' +
        '</div><div id="idx_tbl"></div>';
        tbl=_obj('idx_tbl');
    }

    function _tbl()
    {
        var _cnt=_dirs.concat(_files);if(!tbl)return;if(_cpg>_tpg){_cpg=_tpg;return;}else if(_cpg<1){_cpg=1;return;}var a=(_cpg-1)*_ppg;var b=_cpg*_ppg;var j=0;var html='';
        if(_tpg>1)html+='<p style="padding:5px 5px 0px 7px;color:#202020;text-align:right;"><span class="link" onmousedown="_pp();return false;">Previous</span> ('+_cpg+'/'+_tpg+') <span class="link" onmousedown="_np();return false;">Next</span></p>';
        html+='<table cellspacing="0" cellpadding="5" border="0">';
        for(var i=a;i<b&&i<(_files.length+_dirs.length);++i)
        {
            var f=_cnt[i];var rc=j++&1?_c1:_c2;
            html+='<tr class="datarow" style="background-color:'+rc+'"><td class="firsttd"><input type="checkbox" class="filecheck" name="selected"/>&nbsp;&nbsp;<label><img src="'+f['icon']+'" alt="" /> &nbsp;<a href="'+f['url']+'">'+f['name']+'</a></td></label><td class="center hide2" style="width:50px;">'+(f['dir']?'':_s(f['size']))+'</td><td class="center hide1" style="width:70px;">'+f['date']+'</td></tr>';
        }
        tbl.innerHTML=html+'</table>';
    }
    <?php while(list(,$d)=each($dirs))print sprintf("_d('%s','%s','%s');\n",addslashes($d['name']),date($date,$d['date']),addslashes($d['url'])); ?>
    <?php while(list(,$f)=each($files))print sprintf("_f('%s',%d,'%s','%s',%d);\n",addslashes($f['name']),$f['size'],date($date,$f['date']),addslashes($f['url']),$f['date']);?>

    window.onload=function()
    {
        idx=_obj('idx'); _head(); _srt('name');
    };
    -->
    </script>
</head>

<body id="page-top">
  <span class="contentspan">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>THYDRIVE</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#"><i class="fas fa-upload"></i><span>Upload</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#"><i class="far fa-folder"></i><span>Your Drive</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#"><i class="fas fa-money-check"></i><span>Payments</span></a></li>
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
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in" role="menu">

                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in" role="menu">

                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="http://mathlearn.icu/assets/img/avatars/avatar4.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">

                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="http://mathlearn.icu/assets/img/avatars/avatar2.jpeg">
                                                <div class="status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">

                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="http://mathlearn.icu/assets/img/avatars/avatar3.jpeg">
                                                <div class="bg-warning status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">

                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="http://mathlearn.icu/assets/img/avatars/avatar5.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">

                                            </div>
                                        </a></div>
                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">Valerie Luna</span><img class="border rounded-circle img-profile" src="http://mathlearn.icu/assets/img/avatars/avatar1.jpeg"></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Account</a><a class="dropdown-item" role="presentation" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <a
                                            class="dropdown-item" role="presentation" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                            <div class="dropdown-divider"></div><button class="dropdown-item" id="logoutbtn" role="presentation" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</button></div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
            <div id="idy">
                <div class="rounded gray" style="padding:5px 10px 5px 7px;color:#202020"><p class="left"><a class="delete"><strong>Delete</strong>&nbsp;&nbsp;<a class="rename"><strong>Rename</strong></a><br></p></div>
            </div></br>
            <div id="idx"><!-- do not remove --></div>
        </div>
      </span>
        <div class="deleteprompt" id="deleteprompt">
          <div></div>
          <div class="mt-4">Are you sure you want to delete?</div>
          <div class="mt-4">Once deleted you won't be able to recover them</div>
          <div class="delete-buttons-div"><button class="btn deletecancel">Cancel</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-danger deletedelete">Delete</button></div>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © ThyDrive 2020</span></div></br>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="http://mathlearn.icu/assets/js/theme.js"></script>
    <script>
      $(document).ready(function(){
          $("#logoutbtn").click(function(){
              $.post('http://mathlearn.icu/drive/logout.php',function(data,status){
                  var jdata = JSON.parse(data);
                  if (jdata.success == 1){
                      window.location.href = "http://mathlearn.icu";
                  }
                  else{
                  }
              })
          })
      })
    </script>
    <script>
    $(document).ready(function(){
      $(".filecheck").hide();
      $(".datarow").hover(function(){
        var checkboxes = document.getElementsByClassName("filecheck");
        for (var i = 0; i < checkboxes.length; ++i)
        {
          if (checkboxes[i].checked)
          {

          }
          else
          {
            checkboxes[i].style.display = "none";
          }
        }
        $(this).children("td").children("input").show();
      },
    function(){
      checkbox = $(this).children("td").children("input");
      if (checkbox.is(':checked'))
      {

      }
      else
      {
        checkbox.hide();
      }
    });
  })
    </script>
    <script>
      $(document).ready(function(){
        $(".filecheck").on('click',function(){
          var checkboxes = document.getElementsByClassName("filecheck");
          var count_checked = 0;
          for (i = 0; i < checkboxes.length; ++i)
          {
            if (checkboxes[i].checked)
            {
              count_checked++;
            }
          }
          if (count_checked == 0)
          {
            //document.getElementByClassName("")
            $(".delete").hide();
            $(".rename").hide();
          }
          else if (count_checked == 1)
          {
            $(".delete").show();
            $(".rename").show();
          }
          else if (count_checked > 1)
          {
            $(".delete").show();
            $(".rename").hide();
          }
        })
      })
    </script>
    <script>
      $(document).ready(function(){
        $(".delete").click(function(){
          $(".deleteprompt").show(500);
          $(".contentspan").css("pointer-events","none");
          $(".deleteprompt").css("pointer-events","auto");
          $(".deletecancel").click(function(){
            $(".deleteprompt").hide();
            $(".contentspan").css("pointer-events","auto");
          })
        })
      })
    </script>
    <script>
      $(document).ready(function(){
        $(".deletedelete").click(function(){
          checkboxes = document.getElementsByClassName("filecheck");
          var count = 0;
          for (i = 0; i < checkboxes.length; ++i)
          {
            if (checkboxes[i].checked)
            {
              var folder = 'Hello';
              var td = checkboxes[i].parentElement;
              /*var child = td.children;
              var child1 = child[1].children;
              var child2 = child1[1];
              var name = child2.innerHTML;*/
              var temp1 = td.children;
              var label = temp1[1];
              var temp2 = label.children;
              var anchor = temp2[1];
              var name = anchor.innerHTML;
              //var name = $(this).parent().children(".firsttd").children("label").children("a").text();
              $.post('process.php', {dir : folder, content : name},function(data, status){
                var jdata = JSON.parse(data);
                if (jdata.success == 1)
                {
                  count++;
                  window.location.reload();
                }
              })
            }
          }
          $(".deleteprompt").hide();
          //window.location.reload();
        })
      })
    </script>
</body>

</html>
