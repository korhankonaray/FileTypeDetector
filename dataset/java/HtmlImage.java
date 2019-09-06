/**
 * Copyright 2010 The PlayN Authors
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
package playn.html;

import com.google.gwt.canvas.dom.client.CanvasPixelArray;
import com.google.gwt.canvas.dom.client.Context2d;
import com.google.gwt.canvas.dom.client.ImageData;
import com.google.gwt.dom.client.CanvasElement;
import com.google.gwt.dom.client.Document;
import com.google.gwt.dom.client.ImageElement;
import com.google.gwt.dom.client.NativeEvent;

import pythagoras.f.MathUtil;

import playn.core.Image;
import playn.core.Pattern;
import playn.core.gl.AbstractImageGL;
import playn.core.gl.GLContext;
import playn.core.gl.ImageGL;
import playn.core.gl.Scale;
import playn.core.util.Callback;

public class HtmlImage extends ImageGL<Context2d> {

  private static native boolean isComplete(ImageElement img) /*-{
    return img.complete;
  }-*/;

  private static native void fakeComplete(CanvasElement img) /*-{
   img.complete = true; // CanvasElement doesn't provide a 'complete' property
  }-*/;

  ImageElement img;
  CanvasElement canvas; // Used internally for getRGB

  public HtmlImage(GLContext ctx, Scale scale, CanvasElement img) {
    super(ctx, scale);
    this.canvas = img;
    fakeComplete(img);
    this.img = img.cast();
  }

  public HtmlImage(GLContext ctx, Scale scale, ImageElement img) {
    super(ctx, scale);
    this.img = img;
  }

  /**
   * Returns the {@link ImageElement} that underlies this image. This is for games that need to
   * write custom backend code to do special stuff. No promises are made, caveat coder.
   */
  public ImageElement imageElement() {
    return img;
  }

  @Override
  public float height() {
    return img == null ? 0 : scale.invScaled(img.getHeight());
  }

  @Override
  public float width() {
    return img == null ? 0 : scale.invScaled(img.getWidth());
  }

  @Override
  public void addCallback(final Callback<? super Image> callback) {
    if (isReady()) {
      callback.onSuccess(this);
    } else {
      HtmlPlatform.addEventListener(img, "load", new EventHandler() {
        @Override
        public void handleEvent(NativeEvent evt) {
          callback.onSuccess(HtmlImage.this);
        }
      }, false);
      HtmlPlatform.addEventListener(img, "error", new EventHandler() {
        @Override
        public void handleEvent(NativeEvent evt) {
          callback.onFailure(new RuntimeException("Error loading image " + img.getSrc()));
        }
      }, false);
    }
  }

  @Override
  public boolean isReady() {
    return isComplete(this.img);
  }

  @Override
  public Pattern toPattern() {
    assert isReady() : "Cannot toPattern() a non-ready image";
    return new HtmlPattern(this, repeatX, repeatY);
  }

  @Override
  public void getRgb(int startX, int startY, int width, int height, int[] rgbArray, int offset,
                     int scanSize) {
    assert isReady() : "Cannot getRgb() a non-ready image";

    if (canvas == null) {
        canvas = img.getOwnerDocument().createCanvasElement();
        canvas.setHeight(img.getHeight());
        canvas.setWidth(img.getWidth());
        canvas.getContext2d().drawImage(img, 0, 0);
        // img.getOwnerDocument().getBody().appendChild(canvas);
    }

    Context2d ctx = canvas.getContext2d();
    ImageData imageData = ctx.getImageData(startX, startY, width, height);
    CanvasPixelArray pixelData = imageData.getData();
    int i = 0;
    int dst = offset;
    for (int y = 0; y < height; y++) {
        for (int x = 0; x < width; x ++) {
          int r = pixelData.get(i++);
          int g = pixelData.get(i++);
          int b = pixelData.get(i++);
          int a = pixelData.get(i++);
          rgbArray [dst + x] = a << 24 | r << 16 | g << 8 | b;
        }
        dst += scanSize;
    }
  }

  @Override
  public Image transform(BitmapTransformer xform) {
    return new HtmlImage(ctx, scale, ((HtmlBitmapTransformer) xform).transform(img));
  }

  @Override
  public void clearTexture() {
    // we may be in use on a non-WebGL platform, in which case we should NOOP
    if (ctx != null)
      super.clearTexture();
  }

  @Override
  public void draw(Context2d ctx, float x, float y, float width, float height) {
    ctx.drawImage(img, x, y, width, height);
  }

  @Override
  public void draw(Context2d ctx, float dx, float dy, float dw, float dh,
                   float sx, float sy, float sw, float sh) {
    // adjust our source rect to account for the scale factor
    sx *= scale.factor;
    sy *= scale.factor;
    sw *= scale.factor;
    sh *= scale.factor;
    ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh);
  }

  @Override
  protected Pattern toSubPattern(AbstractImageGL<?> image, boolean repeatX, boolean repeatY,
                                 float x, float y, float width, float height) {
    CanvasElement canvas = Document.get().createElement("canvas").<CanvasElement>cast();
    canvas.setWidth(MathUtil.iceil(width));
    canvas.setHeight(MathUtil.iceil(height));
    canvas.getContext2d().drawImage(img, x, y, width, height, 0, 0, width, height);
    ImageElement subelem = canvas.cast();
    return new HtmlPattern(image, subelem, repeatX, repeatY);
  }

  @Override
  protected void updateTexture(int tex) {
    ((HtmlGLContext) ctx).updateTexture(tex, img);
  }
}
