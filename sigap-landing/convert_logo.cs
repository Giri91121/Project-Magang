using System;
using System.Drawing;
using System.Drawing.Imaging;

public class ImgProc {
    public static void Process() {
        string src = @"C:\Magang1\sigap-landing\public\images\kota makassar2-1.png";
        string whiteDest = @"C:\Magang1\sigap-landing\public\images\logo-brida-white.png";
        
        using (Bitmap b = new Bitmap(src)) {
            // Resize to reasonable size for web if very large (e.g. max width 1200)
            int targetWidth = 1000;
            int targetHeight = (int)((double)b.Height / b.Width * targetWidth);
            
            using (Bitmap resized = new Bitmap(targetWidth, targetHeight, PixelFormat.Format32bppArgb)) {
                using (Graphics g = Graphics.FromImage(resized)) {
                    g.InterpolationMode = System.Drawing.Drawing2D.InterpolationMode.HighQualityBicubic;
                    g.DrawImage(b, 0, 0, targetWidth, targetHeight);
                }
                
                using (Bitmap white = new Bitmap(targetWidth, targetHeight, PixelFormat.Format32bppArgb)) {
                    for (int y = 0; y < targetHeight; y++) {
                        for (int x = 0; x < targetWidth; x++) {
                            Color c = resized.GetPixel(x, y);
                            // If pixel is white or near white background
                            if (c.R > 230 && c.G > 230 && c.B > 230) {
                                white.SetPixel(x, y, Color.FromArgb(0, 0, 0, 0));
                            } else {
                                // For dark / colored parts, make them crisp white with alpha proportional to darkness
                                int darkness = 255 - ((c.R + c.G + c.B) / 3);
                                int alpha = Math.Min(255, (int)(darkness * 1.5) + 30);
                                if (alpha > 255) alpha = 255;
                                white.SetPixel(x, y, Color.FromArgb(alpha, 255, 255, 255));
                            }
                        }
                    }
                    white.Save(whiteDest, ImageFormat.Png);
                    Console.WriteLine("Saved whiteDest: " + whiteDest + " (" + targetWidth + "x" + targetHeight + ")");
                }
            }
        }
    }
}
