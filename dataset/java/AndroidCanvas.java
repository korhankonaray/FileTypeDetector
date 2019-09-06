/**
 * Copyright 2011 The PlayN Authors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
package playn.android;

import java.util.LinkedList;

import android.graphics.Bitmap;
import android.graphics.Matrix;
import android.graphics.PorterDuff;
import android.graphics.Rect;
import android.graphics.RectF;

import playn.core.Canvas;
import playn.core.Gradient;
import playn.core.Path;
import playn.core.Pattern;
import playn.core.TextLayout;
import playn.core.gl.AbstractCanvasGL;

class AndroidCanvas extends AbstractCanvasGL<AndroidCanvas> {

  private static Matrix m = new Matrix();
  private static Rect rect = new Rect();
  private static RectF rectf = new RectF();

  private final android.graphics.Canvas canvas;

  private LinkedList<AndroidCanvasState> paintStack = new LinkedList<AndroidCanvasState>();

  AndroidCanvas(Bitmap bitmap, float width, float height) {
    super(width, height);
    canvas = new android.graphics.Canvas(bitmap);
    paintStack.addFirst(new AndroidCanvasState());
  }

  void draw(Bitmap bitmap, float dx, float dy, float dw, float dh,
            float sx, float sy, float sw, float sh) {
    rect.set((int) sx, (int) sy, (int) (sx + sw), (int) (sy + sh));
    rectf.set(dx, dy, dx + dw, dy + dh);
    canvas.drawBitmap(bitmap, rect, rectf, currentState().prepareImage());
    isDirty = true;
  }

  @Override
  public Canvas clear() {
    canvas.drawColor(0, PorterDuff.Mode.SRC);
    isDirty = true;
    return this;
  }

  @Override
  public Canvas clearRect(float x, float y, float width, float height) {
    canvas.save(android.graphics.Canvas.CLIP_SAVE_FLAG);
    canvas.clipRect(x, y, x + width, y + height);
    // drawColor: "Fill the entire canvas' bitmap (restricted to the current clip) with the
    // specified color and porter-duff xfermode."
    canvas.drawColor(0, PorterDuff.Mode.SRC);
    canvas.restore();
    isDirty = true;
    return this;
  }

  @Override
  public Canvas clip(Path clipPath) {
    canvas.clipPath(((AndroidPath) clipPath).path);
    return this;
  }

  @Override
  public Canvas clipRect(float x, float y, float width, float height) {
    canvas.clipRect(x, y, x + width, y + height);
    return this;
  }

  @Override
  public Path createPath() {
    return new AndroidPath();
  }

  @Override
  public Canvas drawLine(float x0, float y0, float x1, float y1) {
    canvas.drawLine(x0, y0, x1, y1, currentState().prepareStroke());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas drawPoint(float x, float y) {
    canvas.drawPoint(x, y, currentState().prepareStroke());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas drawText(String text, float x, float y) {
    canvas.drawText(text, x, y, currentState().prepareFill());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas fillCircle(float x, float y, float radius) {
    canvas.drawCircle(x, y, radius, currentState().prepareFill());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas fillPath(Path path) {
    canvas.drawPath(((AndroidPath) path).path, currentState().prepareFill());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas fillRect(float x, float y, float width, float height) {
    float left = x;
    float top = y;
    float right = left + width;
    float bottom = top + height;
    canvas.drawRect(left, top, right, bottom, currentState().prepareFill());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas fillRoundRect(float x, float y, float width, float height, float radius) {
    // for some reason setting x, y to non-zero causes the round rect to be distorted
    canvas.translate(x, y);
    rectf.set(0, 0, width, height);
    canvas.drawRoundRect(rectf, radius, radius, currentState().prepareFill());
    canvas.translate(-x, -y);
    isDirty = true;
    return this;
  }

  @Override
  public Canvas fillText(TextLayout layout, float x, float y) {
    ((AndroidTextLayout)layout).draw(canvas, x, y, currentState().prepareFill());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas restore() {
    canvas.restore();
    paintStack.removeFirst();

    assert paintStack.size() > 0 : "Unbalanced save/restore";
    return this;
  }

  @Override
  public Canvas rotate(float angle) {
    canvas.rotate(rad2deg(angle));
    return this;
  }

  @Override
  public Canvas save() {
    canvas.save();
    paintStack.addFirst(new AndroidCanvasState(currentState()));
    return this;
  }

  @Override
  public Canvas scale(float x, float y) {
    canvas.scale(x, y);
    return this;
  }

  @Override
  public Canvas setAlpha(float alpha) {
    currentState().setAlpha(alpha);
    return this;
  }

  public float alpha() {
    return currentState().alpha;
  }

  @Override
  public Canvas setCompositeOperation(Composite composite) {
    currentState().setCompositeOperation(composite);
    return this;
  }

  @Override
  public Canvas setFillColor(int color) {
    currentState().setFillColor(color);
    return this;
  }

  @Override
  public Canvas setFillGradient(Gradient gradient) {
    currentState().setFillGradient((AndroidGradient) gradient);
    return this;
  }

  @Override
  public Canvas setFillPattern(Pattern pattern) {
    currentState().setFillPattern((AndroidPattern) pattern);
    return this;
  }

  @Override
  public Canvas setLineCap(LineCap cap) {
    currentState().setLineCap(cap);
    return this;
  }

  @Override
  public Canvas setLineJoin(LineJoin join) {
    currentState().setLineJoin(join);
    return this;
  }

  @Override
  public Canvas setMiterLimit(float miter) {
    currentState().setMiterLimit(miter);
    return this;
  }

  @Override
  public Canvas setStrokeColor(int color) {
    currentState().setStrokeColor(color);
    return this;
  }

  @Override
  public Canvas setStrokeWidth(float strokeWidth) {
    currentState().setStrokeWidth(strokeWidth);
    return this;
  }

  @Override
  public Canvas strokeCircle(float x, float y, float radius) {
    canvas.drawCircle(x, y, radius, currentState().prepareStroke());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas strokePath(Path path) {
    canvas.drawPath(((AndroidPath) path).path, currentState().prepareStroke());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas strokeRect(float x, float y, float width, float height) {
    float left = x;
    float top = y;
    float right = left + width;
    float bottom = top + height;
    canvas.drawRect(left, top, right, bottom, currentState().prepareStroke());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas strokeRoundRect(float x, float y, float width, float height, float radius) {
    // for some reason setting x, y to non-zero causes the round rect to be distorted
    canvas.translate(x, y);
    rectf.set(0, 0, width, height);
    canvas.drawRoundRect(rectf, radius, radius, currentState().prepareStroke());
    canvas.translate(-x, -y);
    isDirty = true;
    return this;
  }

  @Override
  public Canvas strokeText(TextLayout layout, float x, float y) {
    ((AndroidTextLayout)layout).draw(canvas, x, y, currentState().prepareStroke());
    isDirty = true;
    return this;
  }

  @Override
  public Canvas transform(float m11, float m12, float m21, float m22, float dx, float dy) {
    m.setValues(new float[] {m11, m21, dx, m12, m22, dy, 0, 0, 1});
    canvas.concat(m);
    return this;
  }

  @Override
  public Canvas translate(float x, float y) {
    canvas.translate(x, y);
    return this;
  }

  @Override
  protected AndroidCanvas gc() {
    return this;
  }

  private AndroidCanvasState currentState() {
    return paintStack.peek();
  }

  private float rad2deg(double deg) {
    return (float) (deg * 360 / (2 * Math.PI));
  }
}
