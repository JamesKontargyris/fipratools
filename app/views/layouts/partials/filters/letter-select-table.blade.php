<table class="letter-select-table">
	<tr>
		@if(is_request('users'))
			<td>First / last name begins with:</td>
		@else
			<td>Begins with:</td>
		@endif
		<td><a href="{{ url($key . '/search?search=A&letter=yes') }}" class="secondary">A</a></td>
		<td><a href="{{ url($key . '/search?search=B&letter=yes') }}" class="secondary">B</a></td>
		<td><a href="{{ url($key . '/search?search=C&letter=yes') }}" class="secondary">C</a></td>
		<td><a href="{{ url($key . '/search?search=D&letter=yes') }}" class="secondary">D</a></td>
		<td><a href="{{ url($key . '/search?search=E&letter=yes') }}" class="secondary">E</a></td>
		<td><a href="{{ url($key . '/search?search=F&letter=yes') }}" class="secondary">F</a></td>
		<td><a href="{{ url($key . '/search?search=G&letter=yes') }}" class="secondary">G</a></td>
		<td><a href="{{ url($key . '/search?search=H&letter=yes') }}" class="secondary">H</a></td>
		<td><a href="{{ url($key . '/search?search=I&letter=yes') }}" class="secondary">I</a></td>
		<td><a href="{{ url($key . '/search?search=J&letter=yes') }}" class="secondary">J</a></td>
		<td><a href="{{ url($key . '/search?search=K&letter=yes') }}" class="secondary">K</a></td>
		<td><a href="{{ url($key . '/search?search=L&letter=yes') }}" class="secondary">L</a></td>
		<td><a href="{{ url($key . '/search?search=M&letter=yes') }}" class="secondary">M</a></td>
		<td><a href="{{ url($key . '/search?search=N&letter=yes') }}" class="secondary">N</a></td>
		<td><a href="{{ url($key . '/search?search=O&letter=yes') }}" class="secondary">O</a></td>
		<td><a href="{{ url($key . '/search?search=P&letter=yes') }}" class="secondary">P</a></td>
		<td><a href="{{ url($key . '/search?search=Q&letter=yes') }}" class="secondary">Q</a></td>
		<td><a href="{{ url($key . '/search?search=R&letter=yes') }}" class="secondary">R</a></td>
		<td><a href="{{ url($key . '/search?search=S&letter=yes') }}" class="secondary">S</a></td>
		<td><a href="{{ url($key . '/search?search=T&letter=yes') }}" class="secondary">T</a></td>
		<td><a href="{{ url($key . '/search?search=U&letter=yes') }}" class="secondary">U</a></td>
		<td><a href="{{ url($key . '/search?search=V&letter=yes') }}" class="secondary">V</a></td>
		<td><a href="{{ url($key . '/search?search=W&letter=yes') }}" class="secondary">W</a></td>
		<td><a href="{{ url($key . '/search?search=X&letter=yes') }}" class="secondary">X</a></td>
		<td><a href="{{ url($key . '/search?search=Y&letter=yes') }}" class="secondary">Y</a></td>
		<td><a href="{{ url($key . '/search?search=Z&letter=yes') }}" class="secondary">Z</a></td>
	</tr>
</table>