<div class="field">
    <x-forms.select2 id="status" :options="['' => 'All', '1' => 'Active', '0' => 'Inactive']" name="status" label="Status" selected="{{ request('status') }}" />
</div>
