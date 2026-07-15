<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail; // Lưu ý: Cần có Model này để lưu chi tiết đơn
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * 1. Hiển thị Giỏ hàng để khách Xác nhận số lượng
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('frontend.cart.index', compact('cart'));
    }

    /**
     * 2. Thêm sản phẩm vào Giỏ (Lưu vào Session)
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->applicable_price,
                "thumbnail" => $product->thumbnail,
                "sku" => $product->sku
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    /**
     * 3. Xóa sản phẩm khỏi giỏ
     */
    public function remove($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ!');
    }

    /**
     * API cập nhật số lượng sản phẩm bằng Fetch/AJAX
     */
    public function update(Request $request)
    {
        // Nhận dữ liệu từ JSON body
        $id = $request->id;
        $quantity = (int) $request->quantity;

        // Validation phòng thủ (Defensive Programming)
        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Số lượng không hợp lệ!']);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // 1. Cập nhật số lượng mới vào Session
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            // 2. Tính toán lại Thành tiền của 1 sản phẩm
            $itemTotal = $cart[$id]['price'] * $quantity;

            // 3. Tính toán lại Tổng tiền toàn bộ giỏ hàng
            $cartTotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            // 4. Trả về Response chuẩn JSON
            return response()->json([
                'success' => true,
                'item_total_formatted' => number_format($itemTotal, 0, ',', '.') . 'đ',
                'cart_total_formatted' => number_format($cartTotal, 0, ',', '.') . 'đ'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ!']);
    }

    /**
     * 4. Xác nhận đặt hàng (Lưu vào DB bảng orders và order_details)
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->back()->with('error', 'Giỏ hàng của ông đang trống!');
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Lấy thông tin của khách hàng (đại lý) đang đăng nhập
        $user = Auth::user();

        // 4.1. LƯU BẢNG ORDERS
        $order = new Order();
        $order->user_id = $user->id;
        $order->order_code = 'NK-' . strtoupper(Str::random(6));

        // Cấp phát dữ liệu cho các trường Not Null
        $order->customer_name = $user->name;
        $order->customer_phone = $user->phone ?? 'Chưa cập nhật';
        $order->customer_address = $user->address ?? 'Chưa cập nhật';

        // Dùng setAttribute để tránh IDE báo lỗi ép kiểu ảo
        $order->setAttribute('sub_total', $totalAmount);
        $order->setAttribute('total_amount', $totalAmount);

        $order->status = 'pending';

        $order->save();

        // 4.2. LƯU BẢNG ORDER_DETAILS
        foreach ($cart as $id => $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $item['name'],
                'product_sku' => $item['sku'] ?? null,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price']
            ]);
        }

        // 4.3. Đặt hàng xong thì xóa giỏ hàng đi
        session()->forget('cart');

        return redirect()->route('frontend.account.orders')->with('success', 'Đã gửi yêu cầu đặt hàng thành công!');
    }
}
