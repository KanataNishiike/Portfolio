f = open('blogxx.php','r')
Allf = f.read()
text = Allf.replace('\n','')
print(text)

f.close()
