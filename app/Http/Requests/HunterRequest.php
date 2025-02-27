<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HunterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 入力データの前処理: 電話番号の自動整形
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => preg_replace('/[^0-9]/', '', $this->phone), // 数字以外を削除
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $hunterId = $this->route('hunter')?->id; // ルートパラメータからID取得

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email'],
            'phone' => ['required', 'regex:/^[0-9]{10,11}$/'],
            'region' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
            // 'email' => ['required', 'email', Rule::unique('hunters', 'email')->ignore($hunterId)],
            // 'phone' => ['required', 'regex:/^[0-9]{10,11}$/', Rule::unique('hunters', 'phone')->ignore($hunterId)],
            // 'region' => 'required|string|max:255',
            'licenses' => 'required|array', // 狩猟免許（複数選択）
            'license_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 画像アップロード
            // 'license_expiry' => 'nullable|date', // 免許有効期限
            // 'password' => $hunterId ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前は必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'phone.required' => '電話番号は必須です。',
            // 'phone.regex' => '電話番号は10桁または11桁の数字で入力してください。',
            'phone.unique' => 'この電話番号は既に登録されています。',
            'region.required' => '地域を選択してください。',
            'licenses.required' => '狩猟免許の種類を選択してください。',
            'license_image.image' => '画像ファイルを選択してください。',
            'license_expiry.date' => '有効期限は日付で入力してください。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワードが一致しません。',
        ];
    }
}
