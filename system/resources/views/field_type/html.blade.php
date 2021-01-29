
{{-- html 类型字段 --}}
<el-form-item prop="{{ $id }}" size="small" class="{{ $helpertext ? 'has-helptext' : '' }}">
  <el-tooltip slot="label" content="{{ $id }}" placement="right" effect="dark" popper-class="jc-twig-output">
    <span>{{ $label }}</span>
  </el-tooltip>
  <ckeditor
    ref="ckeditor_{{ $id }}"
    v-model="model.{{ $id }}"
    tag-name="textarea"
    :config="{filebrowserImageBrowseUrl: '{{ short_url('media.select') }}'}"></ckeditor>
  @if ($helpertext)
  <span class="jc-form-item-help"><i class="el-icon-info"></i> {{ $helpertext }}</span>
  @endif
</el-form-item>
