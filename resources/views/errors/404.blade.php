@extends('layout.app')

@section('title', 'الصفحة غير موجودة')

@section('content')
    <div style="min-height: 100vh; display: flex; justify-content: center; align-items: center; background-color: #f5f5f5;">
        <div style="text-align: center;">
            <h1 style="font-size: 120px; margin-bottom: 0; color: #04d39f;">404</h1>
            <h2 style="margin-top: 0; color: #333;">عذرًا، الصفحة غير موجودة</h2>
            <p style="color: #777;">الصفحة التي تبحث عنها قد تكون حُذفت أو تم تغيير رابطها أو أنها غير موجودة.</p>
            <a href="{{ route('login') }}" style="display: inline-block; margin-top: 20px; padding: 10px 25px; background-color: #04d39f; color: white; border-radius: 8px; text-decoration: none;">
                العودة للصفحة الرئيسية
            </a>
        </div>
    </div>
@endsection
