from PIL import Image
 
# this script assumes that 'test.jpg' 
# is in the current working directory http://pythonicprose.blogspot.com/2009/09/python-os-module-and-working-directory.html 
n = Image.open('map_new.png')
n = n.convert('RGB')
m = n.load()
 
 
# get x,y size 
s = n.size


# iterate through x and y (every pixel) 
for x in range(s[0]):
    for y in range(s[1]):
    	r,g,b = m[x,y]
    	if(r>80 and r<120 and g<20 and b< 200 and b> 150):
    		m[x,y]=0,0,0
    	else:
    		m[x,y]=255,255,255
 
# save the doctored image 
n.save('modified2.png', "PNG")
#print (r2,b2,g2)
# removing all the red from a photo 
# makes for a creepy greenish blue (duh..with no red) 
# try it out! 


r,g,b=m[380,502]
print (r,g,b)

